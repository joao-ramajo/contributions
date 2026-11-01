<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\CreateDeposit\CreateDepositInput;
use App\Application\CreateDeposit\CreateDepositUseCase;
use App\Application\CreateUser\CreateUserInput;
use App\Application\CreateUser\CreateUserUseCase;
use App\Domain\Entity\Util;
use App\Infrastructure\Request\PostDepositRequest;
use App\Infrastructure\Request\PostUserRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class PostUser
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $request = PostUserRequest::fromArray($request->getParsedBody());

        $input = new CreateUserInput($request->name, $request->email, $request->password, $request->passwordConfirmation);

        $this->createUserUseCase->execute($input);

        return $response
            ->withStatus(303)
            ->withHeader('Location', '/login');
    }
}
