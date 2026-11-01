<?php

declare(strict_types=1);

namespace App\Application\CreateDeposit;

use App\Domain\Entity\Deposit;
use App\Domain\Interfaces\DepositRepository;
use App\Domain\Interfaces\GoalRepository;

class CreateDepositUseCase
{
    public function __construct(
        private readonly DepositRepository $depositRepository,
        private readonly GoalRepository $goalRepository
    ) {
    }

    public function execute(CreateDepositInput $input): void
    {
        $this->ensureUserHasAccess($input->userId, $input->goalId);
        $deposit = Deposit::create(
            goalId: $input->goalId,
            amount: $input->amount,
            date: $input->date
        );

        $this->depositRepository->persist($deposit);
    }

    private function ensureUserHasAccess(int $userId, int $goalId): void
    {
        $this->goalRepository->getById($userId, $goalId);
    }
}
