<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;
use DateTimeImmutable;

class Goal
{
    public function __construct(
        private(set) ?int $id,
        private(set) int $userId,
        private(set) string $name,
        private(set) Money $targetAmount,
        private(set) Money $monthlyTarget,
        private(set) bool $isMain,
        private(set) History $history,
        private(set) DateTimeImmutable $createdAt
    ) {}

    public static function create(
        string $name,
        int $userId,
        int|string $targetAmount,
        int|string $monthlyTarget,
        bool $isMain = false,
        ?DateTimeImmutable $createdAt = new DateTimeImmutable(),
        ?History $history = new History([]),
        ?int $id = null
    ): self {
        return new self(
            $id,
            $userId,
            $name,
            Money::create($targetAmount),
            Money::create($monthlyTarget),
            $isMain,
            $history,
            $createdAt
        );
    }

    public function progress(): int
    {
        if ($this->targetAmount->value === 0) {
            return 0;
        }

        $actualAmount = $this->history->totalAmount();

        return (int) round(
            ($actualAmount->value / $this->targetAmount->value) * 100
        );
    }

    public function actualAmount(): Money
    {
        return $this->history->totalAmount();
    }

    public function pendingAmount(): Money
    {
        return new Money($this->targetAmount->value - $this->history->totalAmount()->value);
    }

    public function increment(Deposit $deposit): void
    {
        $this->history->add($deposit);
    }

    public function monthsRemaining(): int
    {
        if ($this->pendingAmount()->value === 0) {
            return 0;
        }

        return (int) ceil(
            $this->pendingAmount()->value / $this->monthlyTarget->value
        );;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'targetAmount' => $this->targetAmount->value,
            'monthlyTarget' => $this->monthlyTarget->value,
            'isMain' => $this->isMain
        ];
    }
}
