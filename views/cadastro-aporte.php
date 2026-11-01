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
                <input type="number" id="amount" name="amount" placeholder="Ex: 500.00" min="0.01" step="0.01" autocomplete="off" required>
            </div>
            <button type="submit">Registrar aporte</button>
        </form>
    </div>

</body>

</html>