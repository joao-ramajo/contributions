<?php

declare(strict_types=1);

namespace App\Application\CreateGoal;

use App\Domain\Entity\Goal;
use App\Domain\Interfaces\GoalRepository;

class CreateGoalUseCase
{
    public function __construct(
        private readonly GoalRepository $goalRepository
    ) {}

    public function execute(CreateGoalInput $input): void
    {
        $id = random_int(1, PHP_INT_MAX);;
        $goal = Goal::create(
            id: $id,
            name: $input->name,
            targetAmount: $input->targetAmount,
            monthlyTarget: $input->monthlyTarget,
            isMain: $input->isMain
        );

        $this->goalRepository->persist($goal);
    }
}
