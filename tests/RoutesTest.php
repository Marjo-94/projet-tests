<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesTest extends WebTestCase
{
    public function testHomepageIsUp($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function testAllRoutes()
    {
        yield['/'];
        yield['/fr/boutique'];
        yield['/fr/contact'];
        yield['/fr/contact'];
        yield['/fr/rayon/1'];
        yield['/fr/panier'];
        yield['/fr/panier'];
    }
}
