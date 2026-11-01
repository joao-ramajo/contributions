<?php

declare(strict_types=1);

namespace App\Core;

use Psr\Http\Message\ResponseInterface;

final class View
{
    public function init(string $template, array $data = []): void
    {
        extract($data);
        ob_start();

        require dirname(__DIR__, 2) . "/views/$template.php";
    }

    public function render(ResponseInterface $response): ResponseInterface
    {
        $html = ob_get_clean();

        $response->getBody()->write($html);

        return $response;
    }
}
