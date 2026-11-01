<?php
$currentPage = 'cadastro-usuario';
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
    <main class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h1>Criar conta</h1>
                </div>
            </div>
            <form action="/register" method="POST" id="submit-form">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Seu nome"
                        autocomplete="off"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="seu@email.com"
                        autocomplete="off"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="password-input"
                        placeholder="Mínimo de 8 caracteres"
                        minlength="8"
                        autocomplete="off"
                        required>
                </div>
                <div class="form-group">
                    <label for="passwordConfirmation">Confirmar senha</label>
                    <input
                        type="password"
                        id="passwordConfirmation"
                        name="passwordConfirmation"
                        class="password-input"
                        placeholder="Digite sua senha novamente"
                        minlength="8"
                        autocomplete="off"
                        required>
                </div>
                <div class="form-group">
                    <label for="showPassword"><input type="checkbox" name="showPassword" id="showPassword"> Exibir senha </label>

                </div>
                <button type="submit" class="button-link">
                    Criar conta
                </button>
            </form>
            <p class="auth-footer">
                Já possui uma conta?
                <a href="/login">Entrar</a>
            </p>
        </div>
    </main>

    <script src="/assets/js/showPassword.js"></script>
    <script src="/assets/js/submitForm.js"></script>
</body>

</html>