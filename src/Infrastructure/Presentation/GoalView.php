<?php

declare(strict_types=1);

use App\Domain\Entity\Goal;

class GoalView
{
    public function __construct(
        private Goal $goal
    ) {}

    public static function fromEntity(Goal $goal)
    {
        return new self($goal);
    }

    public function title(): ?string
    {
        return $this->goal->name;
    }
}
