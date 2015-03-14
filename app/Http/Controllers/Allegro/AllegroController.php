<?php namespace Snapbuyer\Http\Controllers\Allegro;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Illuminate\Support\Facades\Cache;
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

    public function getCategories()
    {
        $categories = $this->allegroService->getCategories();

        return $categories;
    }

}
