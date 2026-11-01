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

class PostLogin
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            $request = PostLoginRequest::fromArray($request->getParsedBody());

            $result = $this->loginUseCase->execute(new LoginInput($request->email, $request->password));

            session_regenerate_id(true);

            $_SESSION['user_id'] = $result->userId;

            return $response
                ->withStatus(303)
                ->withHeader('Location', '/metas');
        } catch (DomainException $exception) {
            $_SESSION['error'] = $exception->getMessage();

            return $response
                ->withHeader('Location', '/login')
                ->withStatus(303);
        }
    }
}
