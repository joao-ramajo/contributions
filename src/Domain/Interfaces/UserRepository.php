<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entity\User;

interface UserRepository
{
    public function persist(User $user): void;

    public function findByEmail(string $email): ?User;
}
