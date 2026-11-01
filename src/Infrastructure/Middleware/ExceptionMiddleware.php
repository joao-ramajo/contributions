<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final readonly class ExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {

            ob_start();

            $errorMessage = $exception->getMessage();

            require dirname(__DIR__, 3) . '/views/500.php';

            $html = ob_get_clean();

            $response = $this->responseFactory->createResponse(500);
            $response->getBody()->write($html);

            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
        }
    }
}
