<?php

declare(strict_types=1);

namespace App\Application\CreateDeposit;

use App\Domain\Entity\Deposit;
use App\Domain\Interfaces\DepositRepository;

class CreateDepositUseCase
{
    public function __construct(
        private readonly DepositRepository $depositRepository
    ) {}

    public function execute(CreateDepositInput $input): void
    {
        $id = random_int(1, PHP_INT_MAX);;
        $deposit = Deposit::create(
            id: $id,
            goalId: $input->goalId,
            amount: $input->amount,
            date: $input->date
        );

        $this->depositRepository->persist($deposit);
    }
}
