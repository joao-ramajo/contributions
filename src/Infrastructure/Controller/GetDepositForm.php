<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadGoalList\LoadGoalListUseCase;
use App\Core\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetDepositForm
{
    public function __construct(
        private readonly LoadGoalListUseCase $loadGoalListUseCase
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        View $view
    ): ResponseInterface {
        $userId = $request->getAttribute('userId');
        $goals = $this->loadGoalListUseCase->execute($userId);

        $view->init('cadastro-aporte', [
            'goals' => $goals
        ]);

        return $view->render($response)
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
