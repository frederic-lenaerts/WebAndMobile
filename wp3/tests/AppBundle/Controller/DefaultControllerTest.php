<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');        

        // Test if the heading is loaded
        $this->assertContains('Nice to meet you', $crawler->filter('h1')->text());
        
        // Test if location filter is loaded
        $this->assertContains('Location', $crawler->filter('.dropdown-toggle')->text());
        $this->assertContains('London', $crawler->filter('.dropdown-item')->text());

        // Test whether the heading of the table is being generated
        $this->assertContains('#', $crawler->filter('th')->text());
    }
}