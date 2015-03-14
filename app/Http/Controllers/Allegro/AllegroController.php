<?php namespace Snapbuyer\Http\Controllers\Allegro;

use Carbon\Carbon;
use GuzzleHttp\Stream\Stream;
use Illuminate\Support\Facades\Cache;
use Snapbuyer\Http\Controllers\Controller;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-13
 * Time: 19:59
 */
class AllegroController extends Controller
{

    public function index()
    {
        $itemsList = $this->randomItems(50);

        return response()->json($itemsList);
    }

    public function getAuthorizationToken()
    {

        $encodedCredentials = 'YnJhaW5jb2RlLm1vYmkuMjAxNTpzbUFhbWN6cA==';
        $client             = new Client;
        $client->setDefaultOption('verify', false);

        $method  = 'GET';
        $url     = 'https://api.natelefon.pl/oauth/token';
        $headers = ['Authorization' => "Basic YnJhaW5jb2RlLm1vYmkuMjAxNTpzbUFhbWN6cA=="];

        $request = $client->createRequest($method, $url);
        $request->addHeader('Authorization', "Basic YnJhaW5jb2RlLm1vYmkuMjAxNTpzbUFhbWN6cA==");

        $query = $request->getQuery();
        $query->set('grant_type', 'client_credentials');

        $response = $client->send($request);

        $body  = $response->json();
        $token = $body['access_token'];

        return $token;
    }

    public function getOffers()
    {
        $token = $this->getAuthorizationToken();

        $client = new Client;
        $client->setDefaultOption('verify', false);

        $method = 'POST';
        $url    = 'https://api.natelefon.pl/v2/allegro/offers';

        $request = $client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{
            "category": 1,
            "limit": 10
        }'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $client->send($request);

        $body = $response->json();

        $rawOffers = $body['offers'];
        dd($rawOffers);

        $offers = [];

        foreach ($rawOffers as $offer) {
            $newOffer = [
                'id'        => $offer['id'],
                'name'      => $offer['name'],
                'offer_url' => $offer['source']['url'],
                'image_url' => $offer['mainImage']['large'],
            ];
            $offers[] = $newOffer;
        }

        return $offers;
    }

    public function getRandomOffers()
    {

        if (Cache::has('offers'))
        {
            $offers = Cache::get('offers');

            return $offers;
        }

        $offers = [];
        $categories = $this->getCategories();


        foreach ($categories['categories'] as $category)
        {
            $offers[] = $this->getOfferFromCategory($category['id']);
        }

        $expiresAt = Carbon::now()->addMinutes(10);

        Cache::put('offers', $offers, $expiresAt);

        return $offers;
    }

    public function getOfferFromCategory($category)
    {
        $token = $this->getAuthorizationToken();

        $client = new Client;
        $client->setDefaultOption('verify', false);

        $method = 'POST';
        $url    = 'https://api.natelefon.pl/v2/allegro/offers';

        $request = $client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{
            "category": ' . $category . ',
            "limit": 1
        }'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $client->send($request);

        $body = $response->json();

        $rawOffer = $body['offers'][0];

        $offer    = [
            'id'        => $rawOffer['id'],
            'name'      => $rawOffer['name'],
            'offer_url' => $rawOffer['source']['url'],
            'image_url' => $rawOffer['mainImage']['large'],
            'category_id'=> $category
        ];

        return $offer;
    }

    public function getCategories()
    {
        $token = $this->getAuthorizationToken();

        $client = new Client;
        $client->setDefaultOption('verify', false);

        $method = 'GET';
        $url    = 'https://api.natelefon.pl/v1/allegro/categories';

        $request = $client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{}'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $client->send($request);

        $categories = $response->json();

        return $categories;
    }

    private function randomItems($number)
    {
        $items = [];

        for ($i = 1; $i <= $number; $i++) {
            $id      = rand(1000000000, 9999999999);
            $url     = [
                'http://img16.allegroimg.pl/photos/oryginal/50/93/09/85/5093098540',
                'http://img09.allegroimg.pl/photos/oryginal/50/98/00/72/5098007215',
                'http://img03.allegroimg.pl/photos/oryginal/51/63/32/64/5163326440'
            ];
            $item    = [
                'id'  => $id,
                'url' => $url[rand(0, 2)]
            ];
            $items[] = $item;
        }

        return $items;
    }
}
