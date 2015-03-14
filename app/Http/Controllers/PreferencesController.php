<?php namespace Snapbuyer\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Snapbuyer\Category;
use Snapbuyer\Http\Controllers\Controller;

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-14
 * Time: 03:57
 */

class PreferencesController extends Controller
{

    public function store()
    {
        $categoriesPreferences = Input::get('preferences');
        Log::info($categoriesPreferences);


        $categories = Category::all();


        foreach ($categories as $category) {
            $cat = Category::find($category->id);

            Log::info($cat->weight);
            Log::info($category->category_id);
            Log::info($categoriesPreferences[$category->category_id]);

            $newWeight = $cat->weight + $categoriesPreferences[$category->category_id];
            $cat->weight = $newWeight;
            $cat->save();
        }

        return response()->json('Categories stored');

    }
}
