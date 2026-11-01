<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entity\Goal;

interface GoalRepository
{
    public function persist(Goal $goal): void;

    public function getMain(int $userId): Goal;

    public function getById(int $userId, int $goalId): Goal;

    public function findAllByUserId(int $id): array;
}
