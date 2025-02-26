<?php 

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class AuthenticationE2ETest extends PantherTestCase
{
    public function testLoginProcess(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test@example.com',
            '_password' => 'password123',
        ]);

        $client->submit($form);
        $client->waitFor('.dashboard');

        $this->assertSelectorTextContains('.dashboard', 'Bienvenue');
    }

    public function testFailedLogin(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test@example.com',
            '_password' => 'wrongpassword',
        ]);

        $client->submit($form);
        $client->waitFor('.error');

        $this->assertSelectorTextContains('.error', 'Identifiants incorrects');
    }
}
