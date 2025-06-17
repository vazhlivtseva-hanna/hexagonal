<?php

namespace App\Application\User\Command;

class LoginUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $plainPassword
    ) {}
}
