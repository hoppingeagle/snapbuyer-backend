<?php

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-14
 * Time: 04:00
 */
class PreferencesStoreTest extends TestCase
{

    public function testPreferencesStoreEndpoint()
    {

        $preferences = [
            26013  => 2,
            98553  => 2,
            64477  => 2,
            19732  => 2,
            73973  => 2,
            11763  => 2,
            5      => 2,
            63757  => 2,
            20585  => 2,
            8845   => 2,
            9      => 2,
            122640 => 2,
            6      => 2,
            2      => 2,
            122233 => 2,
            7      => 2,
            3      => 2,
            1      => 2,
            20782  => 2,
            1454   => 2,
            16696  => 2,
            76593  => 2,
            10     => 2,
            3919   => 2,
            122332 => 2,
            4      => 2,
            1429   => 2,
            105411 => 2,
            55067  => 2,
            121882 => 2,
        ];

        $attributes = [
            'preferences' => $preferences
        ];
//        $response = $this->call('POST', '/allegro/categories/preferences/store', $attributes);
        $response = $this->call('POST', '/allegro/categories/preferences/store', $attributes);

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent());
//        print_r($content);
    }
}
