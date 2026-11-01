<?php
$currentPage = 'cadastro-meta';
require dirname(__DIR__) . '/views/components/header.php';

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
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
    <div class="container">
        <form class="card" method="POST" action="/goals" id="submit-form">
            <h2 class="card-title">Nova meta</h2>
            <div class="form-group">
                <label for="name">Nome da meta</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Ex: Entrada do imóvel"
                    autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="targetAmount">Valor objetivo (R$)</label>
                <input
                    type="text"
                    id="targetAmount"
                    name="targetAmount"
                    placeholder="R$ 5000,00"
                    class="money-input"
                    inputmode="numeric"
                    autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="monthlyTarget">Aporte mensal (R$)</label>
                <input
                    type="text"
                    id="monthlyTarget"
                    name="monthlyTarget"
                    class="money-input"
                    placeholder="R$ 10,00"
                    inputmode="numeric"
                    autocomplete="off"
                    required>
            </div>
            <div class="form-group checkbox-group">
                <label for="isMain">
                    <input
                        type="checkbox"
                        id="isMain"
                        name="isMain"
                        value="1">
                    Definir como meta principal
                </label>
            </div>
            <button type="submit">Cadastrar meta</button>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <script src="/assets/js/moneyInput.js"></script>
    <script src="/assets/js/submitForm.js"></script>
</body>

</html>