<?php namespace Snapbuyer\Http\Controllers\Allegro;

use Snapbuyer\Allegro\AllegroService;
use Snapbuyer\Http\Controllers\Controller;

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-13
 * Time: 19:59
 */
class AllegroController extends Controller
{

    private $allegroService;

    function __construct()
    {
        $this->allegroService = new AllegroService();
    }

    public function index()
    {
        $itemsList = $this->allegroService->placeholderItems(30);

        return response()->json($itemsList);
    }

    public function getRandomOffers()
    {

        $offers = $this->allegroService->getRandomOffers();

        return $offers;
    }

    public function createOffersWithPreferenceCache()
    {

        $this->allegroService->createOffersWithPreferencesCache();

        return 'Cache updated';
    }

    public function getOffersWithPreference()
    {

        $offers = $this->allegroService->getOffersWithPreferences();

        return $offers;
    }

    public function getCategories()
    {
        $categories = $this->allegroService->getCategories();

        return $categories;
    }

    public function getAuthorizationToken()
    {
        $token = $this->allegroService->getToken();

        return $token;
    }

}
