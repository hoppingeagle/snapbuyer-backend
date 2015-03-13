<?php namespace Snapbuyer\Http\Controllers\Allegro;

use Snapbuyer\Http\Controllers\Controller;

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
            $item = [
                'id' => $id,
                'url'=> 'http://allegro.pl/ShowItem2.php?item='.$id
            ];
            $items[] = $item;
        }

        return $items;
    }
}
