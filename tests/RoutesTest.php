<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesTest extends WebTestCase
{

    /**
    * @dataProvider urlProvider
     */
    public function testHomepageIsUp($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield['/'];
        yield['/fr/boutique'];
        yield['/fr/contact'];
        yield['/fr/rayon/1'];
        yield['/fr/panier'];
    }
}
