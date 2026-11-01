<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entity\Deposit;

interface DepositRepository
{
    public function persist(Deposit $deposit): void;

    public function findAllByMain(): array;
}
