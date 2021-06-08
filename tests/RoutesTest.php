<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Flex\Path;

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
        yield['/fr/connexion'];
        yield['/fr/accueil'];
        yield['/fr/inscription'];
    }

    //test '/' redirects to Home
    public function testCorrectHome() {
        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');
        $this->assertSame('Welcome !', $crawler->filter('h1'));
    }

    public function testContainsInscription() {
        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');

        $this->assertContains('usager_new',$crawler->filter('a')->extract('href'));
    }
}
