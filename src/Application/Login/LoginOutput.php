<?php

declare(strict_types=1);

namespace App\Application\Login;

readonly class LoginOutput
{
    public function __construct(
        public int $userId
    ) {
    }
}
