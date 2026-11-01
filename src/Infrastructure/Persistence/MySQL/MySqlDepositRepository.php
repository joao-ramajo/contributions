<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Entity\Deposit;
use App\Domain\Interfaces\DepositRepository;
use PDO;

class MySqlDepositRepository implements DepositRepository
{
    public function __construct(
        private readonly PDO $connection
    ) {
    }

    public function persist(Deposit $deposit): void
    {
        if ($deposit->id !== null) {
            $statement = $this->connection->prepare(
                'UPDATE deposits
            SET goal_id = :goal_id,
                amount = :amount,
                date = :date
            WHERE id = :id'
            );

            $statement->execute([
                'id' => $deposit->id,
                'goal_id' => $deposit->goalId,
                'amount' => $deposit->amount->value,
                'date' => $deposit->date->format('Y-m-d H:i:s'),
            ]);

            return;
        }

        $statement = $this->connection->prepare(
            'INSERT INTO deposits (
            goal_id,
            amount,
            date
        ) VALUES (
            :goal_id,
            :amount,
            :date
        )'
        );

        $statement->execute([
            'goal_id' => $deposit->goalId,
            'amount' => $deposit->amount->value,
            'date' => $deposit->date->format('Y-m-d H:i:s'),
        ]);
    }

    public function findAllByMain(): array
    {
        $stmt = $this->connection->query(
            'SELECT deposits.*
            FROM deposits
            INNER JOIN goals ON goals.id = deposits.goal_id
            WHERE goals.is_main = TRUE'
        );

        return array_map(
            fn (array $data): Deposit => Deposit::create(
                id: (int) $data['id'],
                goalId: (int) $data['goal_id'],
                amount: $data['amount'],
                date: new \DateTimeImmutable($data['date'])
            ),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
