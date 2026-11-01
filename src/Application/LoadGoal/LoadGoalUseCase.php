<?php

declare(strict_types=1);

namespace App\Application\LoadGoal;

use App\Domain\Entity\Goal;
use App\Domain\Interfaces\GoalRepository;

class LoadGoalUseCase
{
    public function __construct(
        private readonly GoalRepository $goalRepository
    ) {}

    public function execute(?int $id = null): Goal
    {
        if (!$id) {
            return $this->goalRepository->getMain();
        }

        return $this->goalRepository->getById($id);
    }
}
