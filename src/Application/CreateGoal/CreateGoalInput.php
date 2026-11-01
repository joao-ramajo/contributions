<?php

declare(strict_types=1);

namespace App\Application\CreateGoal;

readonly class CreateGoalInput
{
    public function __construct(
        public string $name,
        public string|int $targetAmount,
        public string|int $monthlyTarget,
        public bool $isMain
    ) {}
}
