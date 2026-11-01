<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class Money
{
    public function __construct(
        public int $value
    ) {}

    public function view(): string
    {
        return 'R$ ' . number_format(
            $this->value / 100,
            2,
            ',',
            '.'
        );
    }
}
