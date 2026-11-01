<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\CreateGoal\CreateGoalInput;
use App\Application\CreateGoal\CreateGoalUseCase;
use App\Domain\Entity\Deposit;
use App\Domain\Entity\Goal;
use App\Infrastructure\Request\PostGoalRequest;
use DateTimeImmutable;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class PostGoal
{
    public function __construct(
        private readonly CreateGoalUseCase $useCase
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            $request = PostGoalRequest::fromArray($request->getParsedBody());


            $this->useCase->execute(new CreateGoalInput($request->name, $request->targetAmount, $request->monthlyTarget, $request->isMain));

            return $response
                ->withStatus(303)
                ->withHeader('Location', '/');
        } catch (DomainException $exception) {
            $_SESSION['error'] = $exception->getMessage();

            return $response
                ->withHeader('Location', '/cadastrar/meta')
                ->withStatus(303);
        } catch (Throwable $exception) {
            echo "erro: " . $exception->getMessage();
            die();
        }
    }
}
