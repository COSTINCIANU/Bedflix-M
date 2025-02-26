<?php 
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('hashed_password');

        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertEquals('hashed_password', $user->getPassword());
    }
}
