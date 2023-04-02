<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
        $this->assertSelectorTextContains('h2', 'Liste des tâches à faire');

        // Test que la pagination affiche un élément lorsqu'il y a des tâches à faire
        $pagination = $crawler->filter('.pagination');
        $this->assertNotEmpty($pagination, 'La pagination doit être présente sur la page');
}
}
