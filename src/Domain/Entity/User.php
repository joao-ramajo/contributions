<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;

class User
{
    public function __construct(
        private(set) ?int $id,
        private(set) string $name,
        private(set) string $email,
        private(set) string $password,
        private(set) DateTimeImmutable $createdAt
    ) {}

    public static function create(
        string $name,
        string $email,
        string $password,
        DateTimeImmutable $createdAt,
        ?bool $isHashed = true,
        ?int $id = null
    ): self {
        if (!$isHashed) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
            createdAt: $createdAt
        );
    }
}
