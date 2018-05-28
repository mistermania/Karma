<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testGetboard()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getBoard');
    }

    public function testSendboard()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendBoard');
    }

}
