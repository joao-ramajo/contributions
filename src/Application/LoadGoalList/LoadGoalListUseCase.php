<?php

declare(strict_types=1);

namespace App\Application\LoadGoalList;

use App\Domain\Interfaces\GoalRepository;

class LoadGoalListUseCase
{
    public function __construct(
        private readonly GoalRepository $goalRepository
    ) {}

    public function execute(): array
    {
        return $this->goalRepository->findAll();
    }
}
