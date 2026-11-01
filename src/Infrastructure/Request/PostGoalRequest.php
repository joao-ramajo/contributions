<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use InvalidArgumentException;

readonly class PostGoalRequest
{
    public function __construct(
        public string $name,
        public int $targetAmount,
        public int $monthlyTarget,
        public bool $isMain
    ) {}

    public static function fromArray(array $data): self
    {
        $name = $data['name'] ?? throw new InvalidArgumentException('O nome da meta não pode ser nulo');
        $targetAmount = $data['targetAmount'] ?? throw new InvalidArgumentException('O valor não pode ser nulo');
        $monthlyTarget = $data['monthlyTarget'] ?? throw new InvalidArgumentException('O aporte mensal não pode ser nulo');
        $isMain = isset($data['isMain']) ?? throw new InvalidArgumentException('A prioridade da meta deve ser informada');

        $targetAmount = (int) round((float) $targetAmount * 100);
        $monthlyTarget = (int) round((float) $monthlyTarget * 100);
        $isMain = (bool) $isMain;

        return new self($name, $targetAmount, $monthlyTarget, $isMain);
    }
}
