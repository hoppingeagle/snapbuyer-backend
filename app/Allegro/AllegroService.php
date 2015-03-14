<?php namespace Snapbuyer\Allegro;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Stream\Stream;
use Illuminate\Support\Facades\Log;
use Snapbuyer\Category;


/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-14
 * Time: 03:03
 */
class AllegroService
{

    private $token;

    private $username;

    private $password;

    private $client;

    function __construct()
    {
        $this->username   = Config::get('allegro.username');
        $this->password   = Config::get('allegro.password');
        $this->base_url   = Config::get('allegro.base_url');
        $this->token_path = Config::get('allegro.token_path');
        $this->client     = new Client;
        $this->client->setDefaultOption('verify', false);
        $this->token      = $this->getToken();
    }

    public function getToken()
    {
        if (Cache::has('token'))
        {
            $token = Cache::get('token');

            return $token;
        }

        $encodedCredentials = base64_encode($this->username . ':' . $this->password);

        $method  = 'GET';
        $url     = $this->base_url.$this->token_path;

        $request = $this->client->createRequest($method, $url);
        $request->addHeader('Authorization', "Basic ".$encodedCredentials);

        $query = $request->getQuery();
        $query->set('grant_type', 'client_credentials');

        $response = $this->client->send($request);

        $body  = $response->json();
        $token = $body['access_token'];

        $expiresAt = Carbon::now()->addMinutes(10);
        Cache::put('token', $token, $expiresAt);

        return $token;
    }

    public function getCategories()
    {
        if (Cache::has('categories'))
        {
            $categories = Cache::get('categories');

            return $categories;
        }

        $token = $this->token;

        $method = 'GET';
        $url    = 'https://api.natelefon.pl/v1/allegro/categories';

        $request = $this->client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{}'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $this->client->send($request);

        $categories = $response->json();

        $expiresAt = Carbon::now()->addMinutes(60);
        Cache::put('categories', $categories, $expiresAt);

        return $categories;
    }

    public function getRandomOffers()
    {
        $cach_id = rand(1,10);

        if (Cache::has('offers'.$cach_id))
        {
            $offers = Cache::get('offers'.$cach_id);

            return $offers;
        }

        $offers = [];
        $categories = $this->getCategories();


        foreach ($categories['categories'] as $category)
        {
            $offers[] = $this->getOfferFromCategory($category['id']);
        }

        $expiresAt = Carbon::now()->addMinutes(10);

        Cache::put('offers'.$cach_id, $offers, $expiresAt);

        return $offers;
    }

    public function getOffersWithPreferences()
    {
        $cache_id = rand(1,10);
        if (Cache::has('offersWithPreferences'.$cache_id))
        {
            $offers = Cache::get('offersWithPreferences'.$cache_id);

            return $offers;
        }

        $offers = [];
        $categories = Category::all();
        $categories->sortByDesc('weight');

        $preferredCategories = $categories->take(20);

        foreach ($preferredCategories as $category)
        {
            Log::info($category['category_id']);
            $offers[] = $this->getRandomOfferFromCategory(($category['category_id']));
        }

        $expiresAt = Carbon::now()->addMinutes(10);

        Cache::put('offersWithPreferences'.$cache_id, $offers, $expiresAt);

        return $offers;
    }

    public function placeholderItems($number)
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

    private function getOfferFromCategory($category)
    {
        $token = $this->getToken();

        $method = 'POST';
        $url    = 'https://api.natelefon.pl/v2/allegro/offers';

        $request = $this->client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{
            "category": ' . $category . ',
            "limit": 1
        }'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $this->client->send($request);

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
    private function getRandomOfferFromCategory($category)
    {
        $token = $this->getToken();

        $method = 'POST';
        $url    = 'https://api.natelefon.pl/v2/allegro/offers';

        $request = $this->client->createRequest($method, $url);
        $request->addHeader('Content-Type', "application/json");
        $request->addHeader('Authorization', "Bearer " . $token);
        $request->setBody(Stream::factory('{
            "category": ' . $category . ',
            "limit": 1,
            "offset": '. rand(1,100).'
        }'));

        $query = $request->getQuery();
        $query->add('access_token', $token);

        $response = $this->client->send($request);

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
}
