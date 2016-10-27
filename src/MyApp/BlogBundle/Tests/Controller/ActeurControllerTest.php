<?php

namespace MyApp\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActeurControllerTest extends WebTestCase
{
    public function testTopacteur()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/topActeur');
    }

}
