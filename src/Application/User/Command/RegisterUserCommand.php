<?php

namespace App\Application\User\Command;

class RegisterUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $plainPassword
    ) {}
}
