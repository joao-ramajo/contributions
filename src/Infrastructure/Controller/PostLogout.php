<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Login\LoginInput;
use App\Application\Login\LoginUseCase;
use App\Domain\Entity\Util;
use App\Infrastructure\Request\PostLoginRequest;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class PostLogout
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            unset($_SESSION['user_id']);

            return $response
                ->withStatus(303)
                ->withHeader('Location', '/login');
        } catch (Throwable $exception) {
            echo "erro: " . $exception->getMessage();
            die();
        }
    }
}
