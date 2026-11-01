<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\CreateDeposit\CreateDepositInput;
use App\Application\CreateDeposit\CreateDepositUseCase;
use App\Infrastructure\Request\PostDepositRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class PostDeposit
{
    public function __construct(
        private readonly CreateDepositUseCase $createDeposit
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            $request = PostDepositRequest::fromArray($request->getParsedBody());

            $this->createDeposit->execute(new CreateDepositInput(
                goalId: $request->goalId,
                amount: $request->amount,
                date: $request->date
            ));

            return $response
                ->withStatus(303)
                ->withHeader('Location', '/');
        } catch (Throwable $exception) {
            echo "erro: " . $exception->getMessage();
            die();
        }
    }
}
