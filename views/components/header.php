<header class="navbar">
    <a href="/" class="navbar-brand">Contributions</a>
    <nav>
        <a href="/" class="<?= $currentPage === 'home' ? 'active' : '' ?>">
            Meta principal
        </a>
        <a href="/metas" class="<?= $currentPage === 'metas' ? 'active' : '' ?>">
            Metas
        </a>
        <a href="/cadastro/meta" class="<?= $currentPage === 'cadastro-meta' ? 'active' : '' ?>">
            Cadastrar meta
        </a>
        <a href="/cadastro/aporte" class="<?= $currentPage === 'cadastro-aporte' ? 'active' : '' ?>">
            Cadastrar aporte
        </a>
    </nav>
</header>