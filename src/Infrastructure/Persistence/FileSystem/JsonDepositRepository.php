<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\FileSystem;

use App\Domain\Entity\Deposit;
use App\Domain\Entity\Goal;
use App\Domain\Entity\History;
use App\Domain\Interfaces\DepositRepository;
use App\Domain\Interfaces\GoalRepository;
use DomainException;

class JsonDepositRepository implements DepositRepository
{
    public function __construct(
        private readonly string $db
    ) {}

    public function persist(Deposit $deposit): void
    {
        $file = json_decode(file_get_contents($this->db));
        $exists = false;

        if ($file->deposits === null) {
            $file->deposits = [];
        }

        foreach ($file->deposits as $item) {
            if ($item->id === $deposit->id) {
                $item->goalId = $deposit->goalId;
                $item->amount = $deposit->amount->value;
                $$item->date = $deposit->date->format('c');
                $exists = true;
            }
        }

        if ($exists === false) {
            $file->deposits[] = $deposit->toArray();
        }


        file_put_contents($this->db, json_encode($file));
    }

    public function findAllByMain(): array
    {
        $file = json_decode(file_get_contents($this->db));

        $mainGoal = null;

        foreach ($file->goals as $goal) {
            if ($goal->isMain) {
                $mainGoal = $goal;
                break;
            }
        }

        if ($mainGoal === null) {
            return [];
        }

        return array_values(array_filter(
            $file->deposits,
            fn($deposit) => $deposit->goalId === $mainGoal->id
        ));
    }
}
