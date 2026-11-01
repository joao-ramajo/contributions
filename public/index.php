<?php

declare(strict_types=1);

use App\Infrastructure\Controller\GetDepositForm;
use App\Infrastructure\Controller\GetGoalDetails;
use App\Infrastructure\Controller\GetGoalForm;
use App\Infrastructure\Controller\GetGoalList;
use App\Infrastructure\Controller\GetLoginForm;
use App\Infrastructure\Controller\GetRegisterUserForm;
use App\Infrastructure\Controller\HomeController;
use App\Infrastructure\Controller\PostDeposit;
use App\Infrastructure\Controller\PostGoal;
use App\Infrastructure\Controller\PostLogin;
use App\Infrastructure\Controller\PostUser;
use App\Infrastructure\Middleware\AuthMiddleware;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;
use Slim\Routing\RouteCollectorProxy;

date_default_timezone_set('America/Sao_Paulo');

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$builder = new ContainerBuilder();

$container = $builder->build();

$configureContainer = require dirname(__DIR__) . '/config/container.php';
$configureContainer($container);

$app = Bridge::create($container);

$app->get('/login', GetLoginForm::class);
$app->post('/login', PostLogin::class);
$app->get('/cadastro', GetRegisterUserForm::class);
$app->post('/register', PostUser::class);

$app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', GetGoalList::class);
    $group->get('/metas', GetGoalList::class);
    $group->get('/metas/{id}', GetGoalDetails::class);
    $group->get('/cadastrar/meta', GetGoalForm::class);
    $group->get('/cadastrar/aporte', GetDepositForm::class);
    $group->post('/goals', PostGoal::class);
    $group->post('/deposits', PostDeposit::class);
})->add(AuthMiddleware::class);

$app->run();
