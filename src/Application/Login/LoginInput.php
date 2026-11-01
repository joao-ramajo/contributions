<?php

declare(strict_types=1);

namespace App\Application\Login;

readonly class LoginInput
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
