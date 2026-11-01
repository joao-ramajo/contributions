<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadDepositList\LoadDepositListUseCase;
use App\Application\LoadGoal\LoadGoalUseCase;
use App\Application\LoadGoalList\LoadGoalListUseCase;
use DateTimeImmutable;
use IntlDateFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(
        private readonly LoadGoalUseCase $loadGoalUseCase,
        private readonly LoadGoalListUseCase $loadGoalListUseCase,
        private readonly LoadDepositListUseCase $loadDepositListUseCase
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {

        $goal = $this->loadGoalUseCase->execute();

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
