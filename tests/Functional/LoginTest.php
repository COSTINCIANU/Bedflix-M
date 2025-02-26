<?php 

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    // On teste si le mot de passe et l'email est valid
    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test@example.com',
            '_password' => 'password123',
        ]);

        $client->submit($form);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Bienvenue');
    }

    // On teste si le mot de passe n'est pas valide
    public function testLoginWithWrongPassword(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test@example.com',
            '_password' => 'wrongpassword',
        ]);

        $client->submit($form);
        
        $this->assertSelectorExists('.error', 'Identifiants incorrects');
    }

    // On test si l'email est invalide
    public function testLoginWithInvalidEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'invalid@example.com',
            '_password' => 'password123',
        ]);

      $client->submit($form);
      
      // Suivre la redirection attendue
      $client->followRedirect('/');  
      // Au lieu de '.error'
      $this->assertSelectorExists('.error', 'Identifiants incorrects');
      // Vérifie si l'utilisateur est bien sur la page d'accueil
      $this->assertSelectorExists('.alert-danger');
      // On affiche si tout vas bien la message bienvenue
      $this->assertSelectorExists('h1:contains("Bienvenue")');  
    }
}
