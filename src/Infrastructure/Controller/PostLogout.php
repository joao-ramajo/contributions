<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Psr\Http\Message\ResponseInterface;

class PostLogout
{
    public function __invoke(
        ResponseInterface $response,
    ): ResponseInterface {
        unset($_SESSION['user_id']);

        return $response
            ->withStatus(303)
            ->withHeader('Location', '/login');
    }
}
