<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Entity\Deposit;
use App\Domain\Entity\Goal;
use App\Domain\Entity\History;
use App\Domain\Exceptions\GoalException;
use App\Domain\Interfaces\GoalRepository;
use DateTimeImmutable;
use PDO;

class MySqlGoalRepository implements GoalRepository
{
    public function __construct(
        private PDO $connection
    ) {}

    public function persist(Goal $goal): void
    {
        if ($goal->id !== null) {
            $statement = $this->connection->prepare(
                'UPDATE goals
             SET name = :name,
                 target_amount = :target_amount,
                 monthly_target = :monthly_target,
                 is_main = :is_main
             WHERE id = :id'
            );

            $statement->execute([
                'id' => $goal->id,
                'name' => $goal->name,
                'target_amount' => $goal->targetAmount->value,
                'monthly_target' => $goal->monthlyTarget->value,
                'is_main' => $goal->isMain,
            ]);

            return;
        }

        $statement = $this->connection->prepare(
            'INSERT INTO goals (
            user_id,
            name,
            target_amount,
            monthly_target,
            is_main
        ) VALUES (
            :user_id,
            :name,
            :target_amount,
            :monthly_target,
            :is_main
        )'
        );

        $statement->execute([
            'user_id' => 1,
            'name' => $goal->name,
            'target_amount' => $goal->targetAmount->value,
            'monthly_target' => $goal->monthlyTarget->value,
            'is_main' => $goal->isMain,
        ]);
    }

    public function getMain(): Goal
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM goals WHERE is_main = TRUE LIMIT 1'
        );

        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            throw new GoalException('Meta não encontrada', 404);
        }

        return $this->hydrate($data);
    }

    public function getById(int $userId, int $goalId): Goal
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM goals WHERE id = :goalId AND user_id = :userId'
        );

        $stmt->execute([
            'userId' => $userId,
            'goalId' => $goalId
        ]);

        $data = $stmt->fetch();

        if (!$data) {
            throw new GoalException('Meta não encontrada', 404);
        }

        return $this->hydrate($data);
    }

    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM goals WHERE user_id = :user_id'
        );

        $stmt->execute(['user_id' => $userId]);

        $goals = [];

        foreach ($stmt->fetchAll() as $data) {
            $goals[] = $this->hydrate($data);
        }

        return $goals;
    }

    private function hydrate(array $data): Goal
    {
        $goal = Goal::create(
            id: (int) $data['id'],
            userId: (int) $data['user_id'],
            name: $data['name'],
            targetAmount: $data['target_amount'],
            monthlyTarget: $data['monthly_target'],
            isMain: (bool) $data['is_main'],
            history: new History([])
        );

        $stmt = $this->connection->prepare(
            'SELECT * FROM deposits WHERE goal_id = :goal_id'
        );

        $stmt->execute(['goal_id' => $goal->id]);

        foreach ($stmt->fetchAll() as $deposit) {
            $goal->increment(
                Deposit::create(
                    id: (int) $deposit['id'],
                    goalId: (int) $deposit['goal_id'],
                    amount: $deposit['amount'],
                    date: new DateTimeImmutable($deposit['date'])
                )
            );
        }

        return $goal;
    }
}
