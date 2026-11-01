<?php

declare(strict_types=1);

namespace App\Application\CreateGoal;

use App\Domain\Entity\Goal;
use App\Domain\Exceptions\GoalException;
use App\Domain\Interfaces\GoalRepository;

class CreateGoalUseCase
{
    public function __construct(
        private readonly GoalRepository $goalRepository
    ) {
    }

    public function execute(CreateGoalInput $input): void
    {
        $this->ensureUserHasNoMainGoal($input->userId, $input->isMain);

        $goal = Goal::create(
            userId: $input->userId,
            name: $input->name,
            targetAmount: $input->targetAmount,
            monthlyTarget: $input->monthlyTarget,
            isMain: $input->isMain
        );

        $this->goalRepository->persist($goal);
    }

    private function ensureUserHasNoMainGoal(int $userId, bool $isMain): void
    {
        if (!$isMain) {
            return;
        }

        try {
            $this->goalRepository->getMain($userId);
        } catch (GoalException) {
            return;
        }

        throw new GoalException('Você já possui uma meta principal cadastrada', 400);
    }
}
