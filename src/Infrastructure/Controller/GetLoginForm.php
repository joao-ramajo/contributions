<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Core\View;
use Psr\Http\Message\ResponseInterface;

class GetLoginForm
{
    public function __invoke(
        ResponseInterface $response,
        View $view
    ): ResponseInterface {
        $view->init('login');

        return $view->render($response)
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
