<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\FileSystem;

use App\Domain\Entity\Deposit;
use App\Domain\Entity\Goal;
use App\Domain\Entity\History;
use App\Domain\Exceptions\GoalException;
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
        //     $goal->history->items
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

    public function getMain(): Goal
    {
        $file = json_decode(file_get_contents($this->db));
        $goal = null;


        foreach ($file->goals as $item) {
            if ($item->isMain === true) {
                $goal = Goal::create(
                    id: $item->id,
                    name: $item->name,
                    targetAmount: (string) $item->targetAmount,
                    monthlyTarget: $item->monthlyTarget,
                    isMain: $item->isMain,
                    history: new History([])
                );
            }
        }

        if (!$goal) {
            throw new GoalException("Meta não encontrada", 404);
        }

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


        return $goal;
    }

    public function getById(int $id): Goal
    {
        $file = json_decode(file_get_contents($this->db));
        $goal = null;

        foreach ($file->goals as $item) {
            if ($item->id === $id) {
                $goal = Goal::create(
                    id: $item->id,
                    name: $item->name,
                    targetAmount: $item->targetAmount,
                    monthlyTarget: $item->monthlyTarget,
                    isMain: $item->isMain,
                    history: new History([])
                );

                break;
            }
        }

        if (!$goal) {
            throw new GoalException("Meta não encontrada", 404);
        }

        foreach ($file->deposits ?? [] as $item) {
            if ($item->goalId === $goal->id) {
                $goal->increment(Deposit::create(
                    id: $item->id,
                    goalId: $item->goalId,
                    amount: $item->amount,
                    date: new DateTimeImmutable($item->date)
                ));
            }
        }

        return $goal;
    }

    public function findAllByUserId(int $userId): array
    {
        $file = json_decode(file_get_contents($this->db));

        $depositsByGoal = [];

        foreach ($file->deposits ?? [] as $deposit) {
            $depositsByGoal[$deposit->goalId][] = Deposit::create(
                id: $deposit->id,
                goalId: $deposit->goalId,
                date: new DateTimeImmutable($deposit->date),
                amount: $deposit->amount
            );
        }

        $goals = [];

        foreach ($file->goals ?? [] as $goal) {
            $history = new History(
                $depositsByGoal[$goal->id] ?? []
            );

            $goals[] = Goal::create(
                id: $goal->id,
                name: $goal->name,
                targetAmount: $goal->targetAmount,
                monthlyTarget: $goal->monthlyTarget,
                isMain: $goal->isMain,
                history: $history
            );
        }

        return $goals;
    }
}
