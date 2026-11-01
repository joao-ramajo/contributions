<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Metas</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #222;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 20px;
        }

        .goal-name {
            font-size: 15px;
            color: #666;
        }

        .goal-progress {
            font-size: 30px;
            font-weight: 700;
            margin: 8px 0;
        }

        .goal-target {
            font-size: 13px;
            color: #888;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: #eee;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0 10px;
        }

        .progress-bar-fill {
            height: 100%;
            background: #16a34a;
            border-radius: 10px;
        }

        .progress-label {
            font-size: 13px;
            color: #16a34a;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #777;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .history-table th,
        .history-table td {
            text-align: left;
            padding: 14px 8px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .history-table th {
            color: #888;
            font-weight: 500;
        }

        .history-table th:last-child,
        .history-table td:last-child {
            text-align: right;
        }

        .history-table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>
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
                    <div
                        class="progress-bar-fill"
                        style="width: <?= htmlspecialchars((string) min(100, max(0, $goal->progress()))) ?>%">
                    </div>
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
                        <?php foreach ($goal->history->itens as $deposit): ?>
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

        <form class="card" method="POST" action="/goals">
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
                    type="number"
                    id="targetAmount"
                    name="targetAmount"
                    placeholder="Ex: 60000.00"
                    min="0.01"
                    step="0.01"
                    required>
            </div>

            <div class="form-group">
                <label for="monthlyTarget">Aporte mensal (R$)</label>
                <input
                    type="number"
                    id="monthlyTarget"
                    name="monthlyTarget"
                    placeholder="Ex: 600.00"
                    min="0.01"
                    step="0.01"
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
        </form>

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
                <input
                    type="datetime-local"
                    id="date"
                    name="date"
                    value="<?= htmlspecialchars((new DateTimeImmutable())->format('Y-m-d\TH:i')) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="amount">Valor do aporte (R$)</label>
                <input
                    type="number"
                    id="amount"
                    name="amount"
                    placeholder="Ex: 500.00"
                    min="0.01"
                    step="0.01"
                    autocomplete="off"
                    required>
            </div>

            <button type="submit">Registrar aporte</button>
        </form>
    </div>
    <style>
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #16a34a;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #16a34a;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #15803d;
        }
    </style>

    </div>

</body>

</html>