<?php

declare(strict_types=1);

use App\Domain\Interfaces\DepositRepository;
use App\Domain\Interfaces\GoalRepository;
use App\Infrastructure\Persistence\FileSystem\JsonDepositRepository;
use App\Infrastructure\Persistence\FileSystem\JsonGoalRepository;
use DI\Container;
use Slim\App;

return static function (Container $container): void {
    $container->set(
        GoalRepository::class,
        new JsonGoalRepository(dirname(__DIR__) . '/var/db.json')
    );
    $container->set(
        DepositRepository::class,
        new JsonDepositRepository(dirname(__DIR__) . '/var/db.json')
    );
};
