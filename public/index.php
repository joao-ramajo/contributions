<?php

declare(strict_types=1);

use App\Infrastructure\Controller\GetDepositForm;
use App\Infrastructure\Controller\GetGoalForm;
use App\Infrastructure\Controller\GetGoalList;
use App\Infrastructure\Controller\HomeController;
use App\Infrastructure\Controller\PostDeposit;
use App\Infrastructure\Controller\PostGoal;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;

date_default_timezone_set('America/Sao_Paulo');

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

$builder = new ContainerBuilder();

$container = $builder->build();

$configureContainer = require dirname(__DIR__) . '/config/container.php';
$configureContainer($container);

$app = Bridge::create($container);

$app->get('/', HomeController::class);
$app->get('/cadastro/meta', GetGoalForm::class);
$app->get('/cadastro/aporte', GetDepositForm::class);
$app->get('/metas', GetGoalList::class);
$app->post('/goals', PostGoal::class);
$app->post('/deposits', PostDeposit::class);

$app->run();
