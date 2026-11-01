<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Metas</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

        <div class="container">
            <?php if ($goal): ?>
                <section class="card">
                    <h2 class="card-title"><?= htmlspecialchars($goal->name) ?></h2>
                    <div class="goal-name">
                        <?= htmlspecialchars($goal->goal) ?>
                    </div>
                    <div class="goal-progress">
                        <?= htmlspecialchars($goal->actualAmount()->view()) ?>
                    </div>
                    <div class="goal-target">
                        de <?= htmlspecialchars($goal->targetAmount->view()) ?>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-bar-fill" style="width: <?= htmlspecialchars((string) min(100, max(0, $goal->progress()))) ?>%"></div>
                    </div>
                    <div class="progress-label">
                        <?= htmlspecialchars((string) $goal->progress()) ?>% concluído
                    </div>
                </section>
                <section class="card">
                    <h2 class="card-title">Projeção</h2>
                    <div class="info-row">
                        <span class="info-label">Aporte mensal</span>
                        <span class="info-value">
                            <?= htmlspecialchars($goal->monthlyTarget->view()) ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Falta alcançar</span>
                        <span class="info-value">
                            <?= htmlspecialchars($goal->pendingAmount()->view()) ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Prazo estimado</span>
                        <span class="info-value">
                            <?php if ($goal->monthlyTarget->value > 0): ?>
                                <?= $years > 0 ? "{$years} ano(s) e " : "" ?>
                                <?= $months ?> mês(es)
                            <?php else: ?>
                                Indefinido
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Meta prevista para</span>
                        <span class="info-value">
                            <?= htmlspecialchars($expectedDateFormatted) ?>
                        </span>
                    </div>
                </section>
            <?php endif; ?>
            <section class="card">
                <h2 class="card-title">Histórico de aportes</h2>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Período</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <?php if ($goal): ?>
                        <tbody>
                            <?php foreach ($goal->history->items as $deposit): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($deposit->date->format('d/m/Y H:i')) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($deposit->amount->view()) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
                </table>
            </section>
        </div>
</body>

</html>
