<?php

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-13
 * Time: 20:26
 */

class AllegroPreferedOffersTest extends TestCase
{

    public function testGetPreferedOffers()
    {
        $response = $this->call('GET', '/allegro/preferedoffers');

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent());

        $this->assertEquals(10, count($content));

    }
}
