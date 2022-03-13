<?php

namespace App\Tests;


use App\DTO\LocationOutput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebTest extends WebTestCase
{
  public function setUp(): void
  {
      $this->client = static::createClient();
  }

  public function testHomepageTempalte(): void 
  {
    $response = $this->client->request('GET', '/');
    $this->assertTrue($this->client->getResponse()->isSuccessful());
    $twig = self::$kernel->getContainer()->get('twig');
    $html = $twig->render('base.html.twig');
    $this->assertGreaterThan(0, $response->filter('html:contains("Marine Traffic Sample API")')->count());
    $this->assertGreaterThan(0, $response->filter('html:contains("Swagger")')->count());
  }
}
