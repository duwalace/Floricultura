<?php
session_start();
require_once 'modelos/Produto.php';

// Buscar produtos em destaque para o carrossel
$produtosDestaque = Produto::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floricultura - Página Inicial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilo-novo.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>
    
    <main>
        <!-- Carrossel -->
        <div class="carousel-container">
            <div id="carrossel-principal" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carrossel-principal" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#carrossel-principal" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carrossel-principal" data-bs-slide-to="2"></button>
                </div>
                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./img/banner1.png" class="d-block w-100" alt="Flores Especiais">
                    </div>
                    <div class="carousel-item">
                        <img src="./img/banner2.png" class="d-block w-100" alt="Arranjos Exclusivos">
                    </div>
                    <div class="carousel-item">
                        <img src="./img/banner3.png" class="d-block w-100" alt="Plantas Ornamentais">
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carrossel-principal" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrossel-principal" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>
        
        <!-- Seção de Serviços -->
        <div class="servicos-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="servico-item">
                            <img src="./img/icon-entrega.png" alt="Entrega Rápida">
                            <span>Entrega em até 3h para todo o Brasil</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="servico-item">
                            <img src="./img/icon-assinatura.png" alt="Clube de Assinatura">
                            <span>Clube de Assinatura</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="servico-item">
                            <img src="./img/icon-horario.png" alt="Agende Horário">
                            <span>Agende o horário da entrega</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="servico-item">
                            <img src="./img/icon-whatsapp.jpg" alt="Compre pelo Whatsapp">
                            <span>Compre pelo Whatsapp</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container my-4">
            <!-- Categorias -->
            <section class="mb-5">
                <h2 class="secao-titulo mb-4">ESCOLHA O SEU PRESENTE</h2>
                
                <div class="row">
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/Buque.png" alt="Buquês">
                            <p>Buquês</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/arranjos.jpg" alt="Arranjos">
                            <p>Arranjos</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/cestas.jpg" alt="Cestas">
                            <p>Cestas</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/plantas.jpg" alt="Plantas">
                            <p>Plantas</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/chocolates.jpg" alt="Chocolates">
                            <p>Chocolates</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="categoria-item">
                            <img src="./img/presentes.png" alt="Presentes">
                            <p>Presentes</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Produtos em Destaque -->
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="secao-titulo mb-0">FLORES COM DESCONTO DE ATÉ 50%</h2>
                    <a href="produtos.php" class="btn btn-outline-primary">Ver Todos</a>
                </div>
                
                <div class="row">
                    <?php foreach(array_slice($produtosDestaque, 0, 4) as $produto): ?>
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
            </section>
            
            <!-- Banner Promocional -->
            <section class="mb-5">
                <div class="row">
                    <div class="col-md-8">
                        <img src="./img/banner4.png" alt="Promoção Especial" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 bg-primary text-white">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                <h3>Presentes com Flores até 50% OFF</h3>
                                <p class="my-4">Aproveite nossas ofertas especiais e surpreenda quem você ama com flores lindas por um preço especial.</p>
                                <a href="produtos.php" class="btn btn-light text-primary fw-bold">COMPRAR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Presentes de Aniversário -->
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="secao-titulo mb-0">PRESENTES DE ANIVERSÁRIO</h2>
                    <a href="produtos.php" class="btn btn-outline-primary">Ver Todos</a>
                </div>
                
                <div class="row">
                    <?php foreach(array_slice($produtosDestaque, 4, 4) as $produto): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 produto-card">
                            <img src="<?= $produto['imagem'] ? 'uploads/' . $produto['imagem'] : 'img/sem-imagem.jpg' ?>" 
                                 class="card-img-top" alt="<?= $produto['nome'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $produto['nome'] ?></h5>
                                <p class="card-text produto-descricao"><?= substr($produto['descricao'], 0, 100) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <p class="produto-preco mb-0">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                                    </div>
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
            </section>
        </div>
    </main>
    
    <?php include 'componentes/rodape.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script-novo.js"></script>
</body>
</html>

