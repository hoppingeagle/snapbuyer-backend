<?php namespace Snapbuyer\Http\Controllers\Allegro;

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
    public function index() {
        $itemsList = $this->randomItems(50);

        return response()->json($itemsList);
    }



    private function randomItems($number)
    {
        $items = [];

        for ($i = 1; $i <= $number; $i++) {
            $id = rand(1000000000,9999999999);
            $url = [
                'http://img16.allegroimg.pl/photos/oryginal/50/93/09/85/5093098540',
                'http://img09.allegroimg.pl/photos/oryginal/50/98/00/72/5098007215',
                'http://img03.allegroimg.pl/photos/oryginal/51/63/32/64/5163326440'
            ];
            $item = [
                'id' => $id,
                'url'=> $url[rand(0,2)]
            ];
            $items[] = $item;
        }

        return $items;
    }
}
