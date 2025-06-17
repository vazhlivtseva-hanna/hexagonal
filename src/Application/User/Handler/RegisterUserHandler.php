<?php

namespace App\Application\User\Handler;

use App\Application\User\Command\RegisterUserCommand;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->userRepository->findByEmail($command->email)) {
            throw new \DomainException('User already exists');
        }

        $user = new User();
        $user->setEmail($command->email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $command->plainPassword);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }
}
