<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'produtos.php' || basename($_SERVER['PHP_SELF']) === 'adicionar-produto.php' || basename($_SERVER['PHP_SELF']) === 'editar-produto.php' ? 'active' : '' ?>" href="produtos.php">
                    <i class="fas fa-box me-2"></i>Produtos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'usuarios.php' || basename($_SERVER['PHP_SELF']) === 'adicionar-usuario.php' || basename($_SERVER['PHP_SELF']) === 'editar-usuario.php' ? 'active' : '' ?>" href="usuarios.php">
                    <i class="fas fa-users me-2"></i>Usuários
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-shopping-cart me-2"></i>Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar me-2"></i>Relatórios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog me-2"></i>Configurações
                </a>
            </li>
        </ul>
        
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Ações Rápidas</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="adicionar-produto.php">
                    <i class="fas fa-plus-circle me-2"></i>Novo Produto
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adicionar-usuario.php">
                    <i class="fas fa-user-plus me-2"></i>Novo Usuário
                </a>
            </li>
        </ul>
    </div>
</nav>

