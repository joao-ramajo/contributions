<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadDepositList\LoadDepositListUseCase;
use App\Application\LoadGoal\LoadGoalUseCase;
use App\Application\LoadGoalList\LoadGoalListUseCase;
use App\Domain\Entity\Util;
use DateTimeImmutable;
use IntlDateFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetGoalDetails
{
    public function __construct(
        private readonly LoadGoalUseCase $loadGoalUseCase,
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $id = (int) $request->getAttribute('id');

        $goal = $this->loadGoalUseCase->execute($id);

        $monthsRemaining = (int) ceil(
            $goal->pendingAmount()->value / $goal->monthlyTarget->value
        );

        $years = intdiv($monthsRemaining, 12);
        $months = $monthsRemaining % 12;

        $expectedDate = (new DateTimeImmutable('first day of this month'))
            ->modify("+{$monthsRemaining} months");

        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN,
            'MMMM yyyy'
        );

        $expectedDateFormatted = $formatter->format($expectedDate);

        ob_start();

        require dirname(__DIR__, 3) . '/views/main.php';

        $html = ob_get_clean();

        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
