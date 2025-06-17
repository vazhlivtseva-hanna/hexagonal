<?php

namespace App\Tests;

use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginControllerTest extends WebTestCase
{
    public function testSuccessfulLoginRedirectsToDashboard(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword($hasher->hashPassword($user, 'password123'));

        $em->persist($user);
        $em->flush();

        $crawler = $client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        self::assertResponseRedirects('/dashboard');

        $client->followRedirect();

        self::assertSelectorExists('h1');
    }
}
