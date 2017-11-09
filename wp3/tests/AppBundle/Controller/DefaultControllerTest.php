<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIfBasicLayoutIsRenderedOnReports()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        
        // Test if the navbar is loaded
        $this->assertContains('Web&Mobile', $crawler->filter('.navbar-brand')->text());

        // Test if the heading is loaded
        $this->assertContains('Nice to meet you', $crawler->filter('h1')->text());
        
        // Test if location filter is loaded
        $this->assertContains('Location', $crawler->filter('.dropdown-toggle')->text());
        $this->assertContains('London', $crawler->filter('.dropdown-item')->text());

        // Test whether the heading of the table is being generated
        $this->assertContains('#', $crawler->filter('th')->text());

        // Test if the footer is shown
        $this->assertContains('Built with Symfony', $crawler->filter('.footer')->text());
    }

    public function testIfBasicLayoutIsRenderedOnStatus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/statuses');

        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');

        // Test if the heading is loaded
        $this->assertContains('Nice to meet you', $crawler->filter('h1')->text());
        
        // Test if location filter is loaded
        $this->assertContains('Location', $crawler->filter('.dropdown-toggle')->text());
        $this->assertContains('London', $crawler->filter('.dropdown-item')->text());

        // Test whether the heading of the table is being generated
        $this->assertContains('#', $crawler->filter('th')->text());

        // Test if the footer is shown
        $this->assertContains('Built with Symfony', $crawler->filter('.footer')->text());
    }
    
    public function testIfFilterByTokyoListsTokyReports()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reports/3');

        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');

        // Assert that 'Tokyo' is found in the UI
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("Tokyo")')->count() );
        
        // Assert that any other location isn't mentioned in the table
        $this->assertEquals( 0, $crawler->filter('td:contains("London")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("New York City")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("Bree")')->count() );
    }
    
    public function testIfFilterByBreeListsBreeStatuses()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/statuses/4');

        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');

        // Assert that 'Bree' is found in the UI
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("Bree")')->count() );
        
        // Assert that any other location isn't mentioned in the table
        $this->assertEquals( 0, $crawler->filter('td:contains("London")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("New York City")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("Tokyo")')->count() );
    }
    
    public function testIfSelectingLocationFilterPerformsRequest()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/statuses/4');
        
        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        
        // London appears only once, Bree appears more than once
        $this->assertEquals( 0, $crawler->filter('td:contains("London")')->count() );
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("Bree")')->count() );
        
        // Find the first (and only) link with "London" as text and click it
        $link = $crawler->filter('a:contains("London")')->eq(0)->link();
        $crawler = $client->click($link);
        
        // Bree appears only once, London appears more than once
        $this->assertEquals( 0, $crawler->filter('td:contains("Bree")')->count() );
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("London")')->count() );
    }
    
    public function testIfClickingLoginMovesToLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        
        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        
        // Check if we're on the main page
        $this->assertContains('Nice to meet you', $crawler->filter('h1')->text());
        
        // Get the Login link from the navbar
        $link = $crawler->filter('a:contains("Login")')->eq(0)->link();
        $crawler = $client->click($link);
        
        // Check if we're on the login page
        $this->assertContains('Login', $crawler->filter('h1')->text());
    }
    
    public function testIfPaginationDoesNotResetLocationFilter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/statuses/2');
        
        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        
        // Check if New York City appears multiple times
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("New York City")')->count() );
        
        // Find a link with "2" - the paginater - and click it
        $link = $crawler->filter('a:contains("2")')->eq(0)->link();
        $crawler = $client->click($link);
        
        // Check if New York City is still the only city to appear
        $this->assertGreaterThanOrEqual( 1, $crawler->filter('td:contains("New York City")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("London")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("Bree")')->count() );
        $this->assertEquals( 0, $crawler->filter('td:contains("Tokyo")')->count() );
    }
    
    public function testIfLocationDoesResetPagination()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?page=2');
        
        // Test for the correct HTTP response
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        
        // Check if the current active page is 2
        $this->assertEquals( 1, $crawler->filter('span.page-link:contains("2")')->count() );
        
        // Find a link with "2" - the paginater - and click it
        $link = $crawler->filter('a:contains("New York City")')->eq(0)->link();
        $crawler = $client->click($link);
        
        // Check if we're back on page 1
        $this->assertEquals( 1, $crawler->filter('span.page-link:contains("1")')->count() );
    }
}