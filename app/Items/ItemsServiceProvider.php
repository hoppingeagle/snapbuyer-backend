<?php namespace Snapbuyer\Items;

use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-14
 * Time: 02:53
 */

class ItemsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Snapbuyer\Items\ItemsProvider',
            'Snapbuyer\Items\AllegroItemsProvider'
        );
    }

}
