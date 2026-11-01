<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Entity\User;
use App\Domain\Interfaces\UserRepository;
use DateTimeImmutable;
use Override;
use PDO;

class MySqlUserRepository implements UserRepository
{
    public function __construct(
        private PDO $connection
    ) {}

    public function persist(User $user): void
    {
        if ($user->id !== null) {
            $statement = $this->connection->prepare(
                'UPDATE users
             SET name = :name,
                 email = :email,
                 password = :password
             WHERE id = :id'
            );

            $statement->execute([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
            ]);

            return;
        }

        $statement = $this->connection->prepare(
            'INSERT INTO users (name, email, password, created_at)
         VALUES (:name, :email, :password, :created_at)'
        );

        $statement->execute([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'created_at' => $user->createdAt->format('Y-m-d H:i:s'),
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $statement->execute([
            'email' => $email
        ]);

        $data = $statement->fetch();

        if (!$data) {
            return null;
        }

        $user = User::create(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            createdAt: new DateTimeImmutable($data['created_at'])
        );

        return $user;
    }
}
