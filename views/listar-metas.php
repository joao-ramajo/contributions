<?php
$currentPage = 'metas';
require dirname(__DIR__) . '/views/components/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas metas</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <main class="container">
        <header class="page-header">
            <div>
                <h1>Minhas metas</h1>
                <p>Acompanhe o progresso das suas metas financeiras.</p>
            </div>

            <a href="/goals/new" class="button-link">
                Nova meta
            </a>
        </header>

        <?php foreach ($goals as $goal): ?>
            <section class="goals-list">

                <a href="/metas/<?= htmlspecialchars($goal->id) ?>" class="goal-card">
                    <div class="goal-card-header">
                        <h2><?= htmlspecialchars($goal->name) ?></h2>
                        <span class="goal-percentage">
                            <?= htmlspecialchars((string) $goal->progress()) ?>%</span>
                    </div>

                    <div class="goal-progress">
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: <?= htmlspecialchars((string) min(100, max(0, $goal->progress()))) ?>%"></div>
                        </div>
                    </div>

                    <div class="goal-card-footer">
                        <span><?= htmlspecialchars($goal->actualAmount()) ?> de <?= htmlspecialchars($goal->targetAmount) ?></span>
                        <span>Aporte mensal: <?= htmlspecialchars($goal->monthlyTarget) ?></span>
                    </div>
                </a>

                </secton>
            <?php endforeach; ?>


    </main>

</body>

</html>