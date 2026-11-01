<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entity\Goal;

interface GoalRepository
{
    public function persist(Goal $goal): void;

    public function getMain(): Goal;

    public function findAll(): array;
}
