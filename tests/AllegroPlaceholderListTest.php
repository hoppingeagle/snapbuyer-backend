<?php

/**
 * Created by PhpStorm.
 * User: Maciej Mikulski
 * Date: 2015-03-13
 * Time: 20:26
 */

class AllegroPlaceholderListTest extends TestCase
{

    public function testGetList()
    {
        $response = $this->call('GET', '/allegro/list');

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent());

        $this->assertEquals(50, count($content));

    }
}
