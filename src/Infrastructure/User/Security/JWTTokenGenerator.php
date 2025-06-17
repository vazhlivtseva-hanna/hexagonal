<?php

namespace App\Infrastructure\User\Security;

use App\Domain\User\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class JWTTokenGenerator
{
    public function __construct(private JWTTokenManagerInterface $jwtManager) {}

    public function generate(User $user): string
    {
        return $this->jwtManager->create($user);
    }
}
