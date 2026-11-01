<?php
$currentPage = 'home';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Metas</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php require dirname(__DIR__) . '/views/components/header.php'; ?>

    <main class="container">
        <section class="card error-card">
            <div class="error-code">500</div>

            <h1 class="card-title">Ocorreu um erro</h1>

            <p class="error-message">
                <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <a href="/" class="button-link">
                Voltar para o início
            </a>
        </section>
    </main>
</body>

</html>