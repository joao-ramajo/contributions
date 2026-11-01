<?php

declare(strict_types=1);

namespace App\Application\LoadGoal;

use App\Domain\Entity\Goal;
use App\Domain\Interfaces\GoalRepository;

class LoadGoalUseCase
{
    public function __construct(
        private readonly GoalRepository $goalRepository
    )
    {
    }

    public function execute(): ?Goal
    {
        return $this->goalRepository->findMain();
    }
}