<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\FileSystem;

use App\Domain\Entity\Deposit;
use App\Domain\Entity\Goal;
use App\Domain\Entity\History;
use App\Domain\Interfaces\GoalRepository;
use DateTimeImmutable;
use DomainException;

class JsonGoalRepository implements GoalRepository
{
    public function __construct(
        private readonly string $db
    ) {}

    public function persist(Goal $goal): void
    {
        $file = json_decode(file_get_contents($this->db));
        $exists = false;
        // $_depositData = array_map(
        //     fn(Deposit $deposit): array => $deposit->toArray(),
        //     $goal->history->itens
        // );

        if ($file->goals === null) {
            $file->goals = [];
        }

        foreach ($file->goals as $item) {
            if ($item->id === $goal->id) {
                $item->name = $goal->name;
                $item->targetAmount = $goal->targetAmount->value;
                $item->isMain = $goal->isMain;
                $item->monthlyTarget = $goal->monthlyTarget->value;
                $exists = true;
            }
        }

        if ($exists === false) {
            $file->goals[] = $goal->toArray();
        }


        file_put_contents($this->db, json_encode($file));
    }

    public function findMain(): ?Goal
    {
        $file = json_decode(file_get_contents($this->db));
        $goal = null;


        foreach ($file->goals as $item) {
            if ($item->isMain === true) {
                $goal = Goal::create(
                    id: $item->id,
                    name: $item->name,
                    targetAmount: $item->targetAmount,
                    monthlyTarget: $item->monthlyTarget,
                    isMain: $item->isMain,
                    history: new History([])
                );
            }
        }

        if ($goal) {

            foreach ($file->deposits as $item) {
                if ($item->goalId === $goal->id) {
                    $goal->increment(Deposit::create(
                        id: $item->id,
                        goalId: $item->goalId,
                        amount: $item->amount,
                        date: new DateTimeImmutable($item->date)
                    ));
                }
            }
        }

        return $goal;
    }

    public function findAll(): array
    {
        $file = json_decode(file_get_contents($this->db));
        $data =  $file->goals;

        if ($data === null) {
            return [];
        }
        return $data;
    }
}
