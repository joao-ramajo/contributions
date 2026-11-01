<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Domain\Exceptions\UserException;
use InvalidArgumentException;

readonly class PostUserRequest
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $passwordConfirmation
    ) {}

    public static function fromArray(array $data): self
    {
        $password = $data['password'] ?? throw new InvalidArgumentException('A senha não pode estar vazia');
        $passwordConfirmation = $data['passwordConfirmation'] ?? throw new InvalidArgumentException('A confirmação da senha não pode estar vazia');

        return new self(
            name: $data['name'] ?? throw new InvalidArgumentException('O nome não pode estar vazio.'),
            email: $data['email'] ?? throw new InvalidArgumentException('O email não pode estar vazio'),
            password: $password,
            passwordConfirmation: $passwordConfirmation
        );
    }
}
