<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadGoalList\LoadGoalListUseCase;
use App\Domain\Entity\Util;
use Exception;
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
        $userId = $request->getAttribute('userId');

        $goals = $this->loadGoalListUseCase->execute($userId);

        ob_start();

        require dirname(__DIR__, 3) . '/views/listar-metas.php';

        $html = ob_get_clean();

        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
