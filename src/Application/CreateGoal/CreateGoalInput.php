<?php

declare(strict_types=1);

namespace App\Application\CreateGoal;

readonly class CreateGoalInput
{
    public function __construct(
        public string $name,
        public string $targetAmount,
        public string $monthlyTarget,
        public bool $isMain
    ) {}
}
