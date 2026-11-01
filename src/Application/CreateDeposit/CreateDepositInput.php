<?php

declare(strict_types=1);

namespace App\Application\CreateDeposit;

use DateTimeImmutable;

readonly class CreateDepositInput
{
    public function __construct(
        public int $goalId,
        public int $amount,
        public DateTimeImmutable $date
    ) {}
}
