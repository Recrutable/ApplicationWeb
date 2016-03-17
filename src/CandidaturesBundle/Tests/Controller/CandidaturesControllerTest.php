<?php

namespace CandidaturesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CandidaturesControllerTest extends WebTestCase
{
    public function testPostuler()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/postuler');
    }

}
