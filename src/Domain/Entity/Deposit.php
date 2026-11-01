<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;
use DateTimeImmutable;

class Deposit
{
    public function __construct(
        private(set) ?int $id,
        private(set) int $goalId,
        private(set) DateTimeImmutable $date,
        private(set) Money $amount
    ) {}

    public static function create(int $goalId, DateTimeImmutable $date, int $amount, ?int $id = null): self
    {
        return new self($id, $goalId, $date, new Money($amount));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'goalId' => $this->goalId,
            'date' => $this->date->format('c'),
            'amount' => $this->amount->value
        ];
    }
}
