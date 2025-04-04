<?php
session_start();
require_once 'modelos/Produto.php';

$id = $_GET['id'] ?? 0;
$produto = Produto::buscarPorId($id);

if (!$produto) {
    header('Location: produtos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produto['nome'] ?> - Floricultura</title>
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
                <li class="breadcrumb-item"><a href="produtos.php">Produtos</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $produto['nome'] ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 mb-4">
                    <img src="<?= $produto['imagem'] ? 'uploads/' . $produto['imagem'] : 'img/sem-imagem.jpg' ?>" 
                         class="img-fluid rounded shadow" alt="<?= $produto['nome'] ?>">
                </div>
                
                <div class="row">
                    <div class="col-3">
                        <img src="<?= $produto['imagem'] ? 'uploads/' . $produto['imagem'] : 'img/sem-imagem.jpg' ?>" 
                             class="img-thumbnail mb-2 cursor-pointer" alt="Miniatura 1">
                    </div>
                    <div class="col-3">
                        <img src="img/produto-thumb2.jpg" class="img-thumbnail mb-2 cursor-pointer" alt="Miniatura 2">
                    </div>
                    <div class="col-3">
                        <img src="img/produto-thumb3.jpg" class="img-thumbnail mb-2 cursor-pointer" alt="Miniatura 3">
                    </div>
                    <div class="col-3">
                        <img src="img/produto-thumb4.jpg" class="img-thumbnail mb-2 cursor-pointer" alt="Miniatura 4">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="mb-3"><?= $produto['nome'] ?></h1>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                        <span class="ms-2 text-muted">(4.5/5)</span>
                    </div>
                    <span class="badge bg-success">Em estoque</span>
                </div>
                
                <div class="mb-4">
                    <span class="produto-preco-antigo fs-5">R$ <?= number_format($produto['preco'] * 1.2, 2, ',', '.') ?></span>
                    <span class="produto-preco fs-1 d-block">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                    <span class="badge bg-danger">-20% OFF</span>
                </div>
                
                <p class="fs-5 mb-4"><?= nl2br($produto['descricao']) ?></p>
                
                <?php if(isset($_SESSION['usuario'])): ?>
                <div class="d-flex gap-3 mb-4">
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary diminuir-quantidade" type="button">-</button>
                        <input type="number" class="form-control text-center quantidade-produto" value="1" min="1">
                        <button class="btn btn-outline-secondary aumentar-quantidade" type="button">+</button>
                    </div>
                    <button class="btn btn-comprar flex-grow-1 adicionar-carrinho-qtd" data-id="<?= $produto['id'] ?>">
                        <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                    </button>
                </div>
                <?php else: ?>
                <div class="mb-4">
                    <button class="btn btn-comprar btn-lg w-100" id="btnLoginComprar">
                        <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                    </button>
                </div>
                <?php endif; ?>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informações do Produto</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Código:</span>
                                <span><?= $produto['id'] ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Categoria:</span>
                                <span>Flores</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Disponibilidade:</span>
                                <span class="text-success">Em estoque</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Entrega:</span>
                                <span>Em até 24h</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-heart me-2"></i>Adicionar à Lista de Desejos
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-share-alt me-2"></i>Compartilhar
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'componentes/rodape.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script-novo.js"></script>
</body>
</html>

