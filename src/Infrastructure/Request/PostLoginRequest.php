<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use InvalidArgumentException;

readonly class PostLoginRequest
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }

    public static function fromArray(array $data): self
    {
        $email = $data['email'] ?? throw new InvalidArgumentException('O email não pode estar vazio');
        $password = $data['password'] ?? throw new InvalidArgumentException('A senha não pode estar vazia');

        return new self(
            email: $email,
            password: $password,
        );
    }
}
