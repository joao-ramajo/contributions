<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadGoalList\LoadGoalListUseCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetGoalList
{
    public function __construct(
        private readonly LoadGoalListUseCase $loadGoalListUseCase
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $goals = $this->loadGoalListUseCase->execute();


        ob_start();

        require dirname(__DIR__, 3) . '/views/listar-metas.php';

        $html = ob_get_clean();

        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
