<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, ['username' => 'user0', 'password' => 'password']);
    }

    public function testListAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/user');
        $this->assertEquals(301, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/user/register');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'autre';
        $form['user[password][first]'] = 'autre';
        $form['user[password][second]'] = 'autre';
        $form['user[email]'] = 'autre@autre.org';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testUpdateAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/user/134/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // Sélectionner le bouton de modification dans la page
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // Récupérer le formulaire lié au bouton de modification
        $form = $buttonCrawlerNode->form();

        // Remplir les champs du formulaire avec les nouvelles données
        $form['user[username]'] = 'nouveau';
        $form['user[plainPassword][first]'] = 'nouveau';
        $form['user[plainPassword][second]'] = 'nouveau';
        $form['user[email]'] = 'nouveau@nouveau.org';
        $form['user[roles][0]']->tick();

        // Soumettre le formulaire
        $this->client->submit($form);

        $this->assertEquals(303, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('div.alert-success')->count());
    }
}
