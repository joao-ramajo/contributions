<?php

declare(strict_types=1);

use App\Domain\Interfaces\DepositRepository;
use App\Domain\Interfaces\GoalRepository;
use App\Domain\Interfaces\UserRepository;
use App\Infrastructure\Persistence\MySQL\MySqlDepositRepository;
use App\Infrastructure\Persistence\MySQL\MySqlGoalRepository;
use App\Infrastructure\Persistence\MySQL\MySqlUserRepository;
use DI\Container;

return static function (Container $container): void {
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME']
        ),
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $container->set(
        GoalRepository::class,
        new MySqlGoalRepository($pdo)
    );
    $container->set(
        DepositRepository::class,
        new MySqlDepositRepository($pdo)
    );

    $container->set(
        UserRepository::class,
        new MySqlUserRepository($pdo)
    );
};
