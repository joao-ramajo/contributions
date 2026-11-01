<?php
$currentPage = 'cadastro-aporte';
require dirname(__DIR__) . '/views/components/header.php';
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
        <form class="card" method="POST" action="/deposits">
            <h2 class="card-title">Novo aporte</h2>
            <div class="form-group">
                <label for="goalId">Meta</label>
                <select id="goalId" name="goalId" required>
                    <?php foreach ($goals as $goal): ?>
                        <option value="<?= htmlspecialchars((string) $goal->id) ?>">
                            <?= htmlspecialchars($goal->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Data do aporte</label>
                <input type="datetime-local" id="date" name="date" value="<?= htmlspecialchars((new DateTimeImmutable())->format('Y-m-d\TH:i')) ?>" required>
            </div>
            <div class="form-group">
                <label for="amount">Valor do aporte (R$)</label>
                <input
                    type="text"
                    id="amount"
                    name="amount"
                    class="money-input"
                    placeholder="R$ 0,00"
                    inputmode="numeric"
                    autocomplete="off"
                    required>
            </div>
            <button type="submit">Registrar aporte</button>
        </form>
    </div>

    <script src="/assets/js/moneyInput.js"></script>
    <script>
        let params = new URLSearchParams(document.location.search);
        let goalId = params.get("meta");
        const goalSelect = document.getElementById("goalId");
        const options = Array.from(goalSelect.options);

        if (goalId !== null) {
            options.forEach(option => {
                if (option.value === goalId) {
                    goalSelect.value = goalId;
                }
            });
        }
    </script>
</body>

</html>