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
        $this->assertSame('Bienvenue sur boublaCar', $crawler->filter('h1'));
    }
    //test homepage contient 10 li
    public function testHomeContainsLi() {

        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');
        $this->assertCount(10, $crawler->filter('li'));
    }

    // test li contains Paths
    public function testHomeContainsPaths() {
        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');
        $this->assertContainsOnlyInstancesOf(Path::class,$crawler->filter('li'));
    }

    public function testContainsRegister() {
        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');

        $this->assertContains('/register',$crawler->filter('a')->extract('href'));
    }

    public function testContainsLogIn() {
        $this->client = self::createClient();
        $crawler = $this->client->request('GET', '/');

        $this->assertContains('/login',$crawler->filter('a')->extract('href'));
    }

    public function testLoginTrue()
    {
        $credential = [
            'email' => 'user@gmail.com',
            'password' => 'user'
        ];
        $this->post('login',$credential)->assertRedirect('/');
    }

    public function testLoginFalse()
    {
        $credential = [
            'email' => 'usera@gmil.com',
            'password' => 'usera'
        ];
        $this->post('login',$credential)->assertRedirect('/login');
    }
}
