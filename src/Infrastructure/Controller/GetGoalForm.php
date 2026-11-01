<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Core\View;
use Psr\Http\Message\ResponseInterface;

class GetGoalForm
{
    public function __invoke(
        ResponseInterface $response,
        View $view
    ): ResponseInterface {
        $view->init('cadastro-meta');

        return $view->render($response)
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
