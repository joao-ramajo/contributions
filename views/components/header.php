<?php
$isLogged = isset($_SESSION['user_id']) ? $_SESSION['user_id'] !== null : false;

?>
<header class="navbar">
    <a href="/" class="navbar-brand">Contributions</a>
    <nav>
        <?php if ($isLogged): ?>
            <a href="/metas" class="<?= $currentPage === 'metas' ? 'active' : '' ?>">
                Metas
            </a>
            <a href="/cadastrar/meta" class="<?= $currentPage === 'cadastro-meta' ? 'active' : '' ?>">
                Cadastrar meta
            </a>
            <a href="/cadastrar/aporte" class="<?= $currentPage === 'cadastro-aporte' ? 'active' : '' ?>">
                Cadastrar aporte
            </a>

            <form action="/logout" method="POST">
                <button type="submit" class="<?= $currentPage === 'logout' ? 'active' : '' ?>">
                    Sair
                </button>
            </form>
        <?php else: ?>
            <a href="/login" class="<?= $currentPage === 'login' ? 'active' : '' ?>">
                Login
            </a>
            <a href="/cadastro" class="<?= $currentPage === 'cadastro-usuario' ? 'active' : '' ?>">
                Cadastre-se
            </a>
        <?php endif; ?>
    </nav>
</header>