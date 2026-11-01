<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use DateTimeImmutable;
use InvalidArgumentException;

readonly class PostDepositRequest
{
    public function __construct(
        public int $goalId,
        public int $amount,
        public DateTimeImmutable $date
    ) {}

    public static function fromArray(array $data): self
    {
        $goalId = $data['goalId'] ?? throw new InvalidArgumentException('É necessario ter uma meta para cadastrar um deposito.');
        $date = $data['date'] ?? throw new InvalidArgumentException('É necessario informar uma data válida');
        $amount = $data['amount'] ?? throw new InvalidArgumentException('É necesário informar um valor válido');


        $goalId = (int) $goalId;
        $amount = (int) round((float) $amount * 100);
        $date = new DateTimeImmutable($date);

        return new self(
            goalId: $goalId,
            amount: $amount,
            date: $date
        );
    }
}
