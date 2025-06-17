<?php

namespace App\Application\User\Handler;


use App\Application\User\Command\LoginUserCommand;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoginUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $hasher,
        private TokenStorageInterface $tokenStorage,
        private RequestStack $requestStack
    ) {}

    public function __invoke(LoginUserCommand $command): void
    {
        $user = $this->userRepository->findByEmail($command->email);

        if (!$user || !$this->hasher->isPasswordValid($user, $command->plainPassword)) {
            throw new AuthenticationException('Invalid credentials');
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $session = $this->requestStack->getSession();
        $session->set('_security_main', serialize($token));
    }
}
