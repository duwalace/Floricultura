<?php
session_start();
require_once 'modelos/Produto.php';

$termo = $_GET['busca'] ?? '';
if (!empty($termo)) {
    $produtos = Produto::buscarPorNome($termo);
} else {
    $produtos = Produto::listarTodos();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilo-novo.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>
    
    <main class="container my-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produtos</li>
            </ol>
        </nav>
        
        <h1 class="secao-titulo mb-4">Nossos Produtos</h1>
        
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="produtos.php" method="get" class="busca-form">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar produtos..." value="<?= htmlspecialchars($termo) ?>">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <?php if (empty($produtos)): ?>
        <div class="alert alert-info text-center">
            Nenhum produto encontrado.
        </div>
        <?php else: ?>
        <div class="row">
            <?php foreach($produtos as $produto): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 produto-card">
                    <img src="<?= $produto['imagem'] ? 'uploads/' . $produto['imagem'] : 'img/sem-imagem.jpg' ?>" 
                         class="card-img-top" alt="<?= $produto['nome'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $produto['nome'] ?></h5>
                        <p class="card-text produto-descricao"><?= substr($produto['descricao'], 0, 100) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <p class="produto-preco-antigo">R$ <?= number_format($produto['preco'] * 1.2, 2, ',', '.') ?></p>
                                <p class="produto-preco mb-0">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                            </div>
                            <span class="badge bg-danger">-20%</span>
                        </div>
                        <a href="detalhes-produto.php?id=<?= $produto['id'] ?>" class="btn btn-outline-primary w-100 mb-2">Ver Detalhes</a>
                        <?php if(isset($_SESSION['usuario'])): ?>
                        <button class="btn btn-comprar w-100 adicionar-carrinho" data-id="<?= $produto['id'] ?>">
                            <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                        </button>
                        <?php else: ?>
                        <button class="btn btn-comprar w-100" id="btnLoginComprar">
                            <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </main>
    
    <?php include 'componentes/rodape.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script-novo.js"></script>
</body>
</html>

