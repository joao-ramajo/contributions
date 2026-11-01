<?php

declare(strict_types=1);

namespace App\Application\LoadDepositList;

use App\Domain\Interfaces\DepositRepository;

class LoadDepositListUseCase
{
    public function __construct(
        private readonly DepositRepository $depositRepostiry
    ) {
    }

    public function execute(): array
    {
        return $this->depositRepostiry->findAllByMain();
    }
}
