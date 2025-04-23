<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= isset($admin) ? '../index.php' : 'index.php' ?>">
                <img src="<?= isset($admin) ? '../img/logo.png' : 'img/logo.png' ?>" alt="Floricultura">
            </a>
            <div class="d-flex align-items-center order-lg-2">
                <form class="busca-form me-3 d-none d-md-block" action="<?= isset($admin) ? '../produtos.php' : 'produtos.php' ?>">
                    <input type="text" name="busca" class="form-control" placeholder="O que está procurando?">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                
                <div class="entrega-form me-3 d-none d-md-block">
                    <input type="text" class="form-control" placeholder="Onde vamos entregar?">
                    <button type="button"><i class="fas fa-map-marker-alt" ></i></button>
                </div>
                
                <?php if (isset($_SESSION['usuario'])): ?>
                <div class="dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i><?= $_SESSION['usuario']['nome'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-bag me-2"></i>Meus Pedidos</a></li>
                        <?php if ($_SESSION['usuario']['tipo'] === 'admin'): ?>
                        <li><a class="dropdown-item" href="<?= isset($admin) ? 'index.php' : 'admin/index.php' ?>"><i class="fas fa-cog me-2"></i>Painel Admin</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= isset($admin) ? '../logout.php' : 'logout.php' ?>"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                    </ul>
                </div>
                <a class="btn btn-outline-primary position-relative me-3" href="<?= isset($admin) ? '../carrinho.php' : 'carrinho.php' ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger carrinho-contador">0</span>
                </a>
                <?php else: ?>
                <button type="button" class="btn btn-link btn-login-custom me-3" id="btnLogin">
                    <i class="fas fa-user me-1"></i><strong>Entrar</strong>
                </button>
                <?php endif; ?>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="busca-form my-3 d-md-none" action="<?= isset($admin) ? '../produtos.php' : 'produtos.php' ?>">
                    <input type="text" name="busca" class="form-control" placeholder="O que está procurando?">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="entrega-form my-3 d-md-none">
                    <input type="text" class="form-control" placeholder="Onde vamos entregar?">
                    <button type="button"><i class="fas fa-map-marker-alt"></i></button>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= isset($admin) ? '../index.php' : 'index.php' ?>">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= isset($admin) ? '../produtos.php' : 'produtos.php' ?>">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="barra-categorias d-none d-md-block">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">Buquês</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Arranjos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cestas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Plantas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Presentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aniversário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Casamento</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="modal-login" id="modalLogin">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-user"></i> ENTRE NA SUA CONTA</h2>
            <button type="button" class="close-btn" id="closeLogin">&times;</button>
        </div>
        <div class="modal-body">
            
            <form id="loginForm">
                <div class="form-control">
                    <input type="email" name="email" id="loginEmail" placeholder="E-mail" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="form-control">
                    <input type="password" name="senha" id="loginSenha" placeholder="Senha" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                
                <button type="submit" class="btn-entrar">ENTRAR</button>
            </form>
            
            <div class="forgot-password">
                <a href="#">Esqueceu sua senha?</a>
            </div>
        </div>
        <div class="modal-footer">
            <p>Novo por aqui? <a href="#" id="btnShowCadastro">Crie sua conta</a></p>
        </div>
    </div>
</div>

<div class="modal-cadastro" id="modalCadastro">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-user-plus"></i> CRIE SUA CONTA</h2>
            <button type="button" class="close-btn" id="closeCadastro">&times;</button>
        </div>
        <div class="modal-body">
            
            <form id="cadastroForm">
                <div class="form-control">
                    <input type="email" name="email" id="cadastroEmail" placeholder="E-mail" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="form-control">
                    <input type="text" name="nome" id="cadastroNome" placeholder="Nome completo" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="tel" name="telefone" id="cadastroTelefone" placeholder="Telefone/Whatsapp" required>
                    <i class="fas fa-phone"></i>
                </div>
                <div class="form-control">
                    <input type="password" name="senha" id="cadastroSenha" placeholder="Senha" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                
                <button type="submit" class="btn-cadastrar">CRIAR CONTA</button>
            </form>
        </div>
        <div class="modal-footer">
            <p>Já tem uma conta? <a href="#" id="btnShowLogin">Faça seu Login</a></p>
        </div>
    </div>
</div>

