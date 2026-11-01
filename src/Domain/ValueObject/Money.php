<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class Money
{
    public function __construct(
        public int $value
    ) {}

    public static function create(int|string $value): self
    {
        if (is_string($value)) {
            $value = (int) preg_replace('/\D/', '', $value);
        }

        return new self($value);
    }

    public function __toString(): string
    {
        return 'R$ ' . number_format(
            $this->value / 100,
            2,
            ',',
            '.'
        );
    }
}
