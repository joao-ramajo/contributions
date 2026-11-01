<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\LoadGoal\LoadGoalUseCase;
use App\Core\View;
use DateTimeImmutable;
use IntlDateFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetGoalDetails
{
    public function __construct(
        private readonly LoadGoalUseCase $loadGoalUseCase,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        View $view
    ): ResponseInterface {
        $id = (int) $request->getAttribute('id');
        $userId = (int) $request->getAttribute('userId');

        $goal = $this->loadGoalUseCase->execute($userId, $id);

        $monthsRemaining = $goal->monthsRemaining();

        $years = intdiv($monthsRemaining, 12);
        $months = $monthsRemaining % 12;

        $expectedDate = new DateTimeImmutable('first day of this month')
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

        $view->init('main', [
            'expectedDateFormatted' => $expectedDateFormatted,
            'years' => $years,
            'months' => $months,
            'goal' => $goal
        ]);

        return $view->render($response)->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
