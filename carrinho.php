<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'modelos/Carrinho.php';

$carrinho = new Carrinho();
$itens = $carrinho->getItens();
$total = $carrinho->getTotal();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Floricultura</title>
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
                <li class="breadcrumb-item active" aria-current="page">Carrinho de Compras</li>
            </ol>
        </nav>
        
        <h1 class="secao-titulo mb-4">Carrinho de Compras</h1>
        
        <?php if (empty($itens)): ?>
        <div class="alert alert-info">
            <p class="mb-0">Seu carrinho está vazio.</p>
        </div>
        <div class="mt-4">
            <a href="produtos.php" class="btn btn-comprar">
                <i class="fas fa-shopping-bag me-2"></i>Continuar Comprando
            </a>
        </div>
        <?php else: ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Preço</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($itens as $id => $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $item->getProduto()['imagem'] ? 'uploads/' . $item->getProduto()['imagem'] : 'img/sem-imagem.jpg' ?>" 
                                             alt="<?= $item->getProduto()['nome'] ?>" class="img-thumbnail me-3" style="width: 80px;">
                                        <div>
                                            <h5 class="mb-0"><?= $item->getProduto()['nome'] ?></h5>
                                            <small class="text-muted">Código: <?= $item->getProduto()['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">R$ <?= number_format($item->getProduto()['preco'], 2, ',', '.') ?></td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm mx-auto" style="width: 120px;">
                                        <button class="btn btn-outline-secondary atualizar-quantidade" data-id="<?= $id ?>" data-acao="diminuir" type="button">-</button>
                                        <input type="number" class="form-control text-center quantidade-carrinho" value="<?= $item->getQuantidade() ?>" min="1" data-id="<?= $id ?>">
                                        <button class="btn btn-outline-secondary atualizar-quantidade" data-id="<?= $id ?>" data-acao="aumentar" type="button">+</button>
                                    </div>
                                </td>
                                <td class="text-center fw-bold produto-preco">R$ <?= number_format($item->getSubtotal(), 2, ',', '.') ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger remover-item" data-id="<?= $id ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Cupom de Desconto</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Digite seu cupom">
                            <button class="btn btn-outline-primary" type="button">Aplicar</button>
                        </div>
                    </div>
                </div>
                
                <a href="produtos.php" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                </a>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Resumo do Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Desconto:</span>
                            <span>R$ 0,00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frete:</span>
                            <span>Grátis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span class="produto-preco fs-4">R$ <?= number_format($total, 2, ',', '.') ?></span>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-comprar limpar-carrinho">
                                <i class="fas fa-trash me-2"></i>Limpar Carrinho
                            </button>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Finalizar Compra
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>
    
    <?php include 'componentes/rodape.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script-novo.js"></script>
</body>
</html>

