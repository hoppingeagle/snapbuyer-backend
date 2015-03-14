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
        $preferences = [];

        for ($i = 1; $i<=30; $i++) {
            $preferences[] = [$i => $i];
        }
        $attributes = [
            'preferences' => $preferences
        ];
        $response = $this->call('GET', '/allegro/categories/preferences/store', $attributes);

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent());
//        print_r($content);
    }
}
