<?php
$currentPage = 'login';
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

    <main class="container">
        <div class="card">
            <div class="card-title">
                <h1>Entrar</h1>
                <p style="font-size: 12px;">Acesse sua conta para acompanhar suas metas financeiras.</p>
            </div>

            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="seu@email.com"
                        autocomplete="email"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="password-input"
                        placeholder="Sua senha"
                        autocomplete="current-password"
                        required>
                </div>
                <div class="form-group">
                    <label for="showPassword"><input type="checkbox" name="showPassword" id="showPassword"> Exibir senha </label>

                </div>

                <button type="submit" class="button-link">
                    Entrar
                </button>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
            </form>

            <p class="auth-footer">
                Ainda não possui uma conta?
                <a href="/cadastro">Criar conta</a>
            </p>
        </div>
    </main>

    <script src="/assets/js/showPassword.js"></script>
</body>

</html>