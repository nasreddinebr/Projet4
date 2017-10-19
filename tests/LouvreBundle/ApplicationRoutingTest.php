<?php
namespace Tests\LouvreBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationRoutingTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url) {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider() {
        return array(
          array('/'),
          array('/billetterie'),
          array('/detaile/1/1'),
          array('/count-visitors/20-11-2017'),
          array('/prix/17-08-1980/20-11-2017/1'),
          array('/tarif-reduit/1/1'),
        );
    }

}
