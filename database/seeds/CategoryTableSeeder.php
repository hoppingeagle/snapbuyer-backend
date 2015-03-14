<?php
/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-14
 * Time: 01:52
 */

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Snapbuyer\Category;

class CategoryTableSeeder extends Seeder
{

    /**
     * Run the Category table seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $numberOfCategories = 30;

        for ($i = 1; $i <= $numberOfCategories; $i++) {
            Category::create(array(
                'category_id' => $i,
                'weight'      => 0
            ));
        }

    }
}
