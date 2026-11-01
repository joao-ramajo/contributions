<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;

class History
{
    /**
     * @param Deposit[] $itens
     */
    public function __construct(
        private(set) array $itens
    ) {}

    public function totalAmount(): Money
    {
        $total = array_reduce(
            $this->itens,
            fn(int $total, Deposit $deposit): int =>
            $total + $deposit->amount->value,
            0
        );

        return new Money($total);
    }

    public function add(Deposit $deposit): void
    {
        $this->itens[] = $deposit;
    }

}
