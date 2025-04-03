<?php
session_start();

include '../php/conexao.php';

$nome_usuario = isset($_SESSION["nome_usuario"]) ? $_SESSION["nome_usuario"] : "Visitante";

// Buscando produtos do banco
try {
    $sql = "SELECT * FROM produtos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Viva-Flor</title>
  <link href="../css/principal.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
  
<!-- Nav-Bar -->
<div class="navbar">
  <div class="navbar-top">
    <div class="brand">
      <a href="../principal.php"><img src="../img/logo.png" alt="Viva-Flor Logo"></a>
    </div>
    <div class="search-container">
      <input type="text" class="search-bar" placeholder="Que está procurando?">
    </div>
    <div class="user-actions">
      <?php if(isset($_SESSION["nome_usuario"])): ?>
        <div class="user-welcome">
          <span>Olá, <?php echo htmlspecialchars($_SESSION["nome_usuario"]); ?></span>
          <form action="../php/logout.php" method="post">
            <button type="submit" class="logout-btn">
              <img src="../img/sair.png" alt="Logout">
            </button>
          </form>
        </div>
        <a href="#" class="cart-btn" onclick="abrirCarrinho()">
          <img src="../img/carrinho.png" alt="Carrinho">
        </a>
      <?php else: ?>
        <a href="#" class="action-btn" onclick="abrirModalLogin()">
         
          <span>AJUDA</span>
        </a>
        <a href="#" class="action-btn" onclick="abrirModalLogin()">
          <span>ENTRE</span>
        </a>
        <a href="#" class="cart-btn" onclick="abrirCarrinho()">
          <img src="../img/carrinho.png" alt="Carrinho">
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Categories Menu -->
<div class="categories">
  <ul>
    <li><a href="#">TIPOS DE FLORES</a></li>
    <li><a href="../Buque/Buque.php">BUQUES DE FLORES</a></li>
    <li><a href="../Floresemvaso/Floresemvaso.php">FLORES EM VASO</a></li>
    <li><a href="../Arranjodeflores/Arranjodeflores.php">ARRANJOS DE FLORES</a></li>
    <li><a href="../Cesta/Cesta.php">CESTA PARA PRESENTE</a></li>
    <li><a href="#">CIDADES</a></li>
  </ul>
</div>

  <!-- Carousel -->
  <div class="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../img/banner1.png" alt="Floral Arrangement">
      </div>
      <div class="carousel-item">
        <img src="../img/banner2.png" alt="Bouquet">
      </div>
      <div class="carousel-item">
        <img src="../img/banner3.png" alt="Bouquet">
      </div>
      <div class="carousel-item">
        <img src="../img/banner4.png" alt="Bouquet">
      </div>
    </div>
    
    <!-- Controles de navegação -->
    <div class="carousel-control prev">&#10094;</div>
    <div class="carousel-control next">&#10095;</div>
    
    <!-- Indicadores de página -->
    <div class="carousel-indicators">
      <div class="carousel-indicator active" data-slide="0"></div>
      <div class="carousel-indicator" data-slide="1"></div>
      <div class="carousel-indicator" data-slide="2"></div>
      <div class="carousel-indicator" data-slide="3"></div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="content-section">
    <h1>Flores para todas ocasiões</h1>
    <button class="cta-button">PEÇA AGORA MESMO</button>
    <div class="features">
      <div class="feature-item">
        <h3>Entrega Rápida</h3>
      </div>
      <div class="feature-item">
        <h3>Loja Física</h3>
      </div>
      <div class="feature-item">
        <h3>Aceitamos Cartões</h3>
      </div>
    </div>
  </div>

  <!-- Modal do Carrinho -->
  <div id="carrinhoModal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close" onclick="fecharCarrinho()">×</span>
      <h2>Carrinho de Compras</h2>
      <div id="carrinhoItens">
        <!-- Itens do carrinho serão adicionados aqui -->
      </div>
      <button class="btn-submit" onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
  </div>

  <!-- Modal de Login -->
  <div id="loginModal" class="modal" style="display: none;">
    <div class="modal-content">
      <div class="close-container">
        <span class="close" onclick="fecharModal()">×</span>
      </div>
      <h2>ENTRE NA SUA CONTA</h2>
      <button class="google-login">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
        Entrar com Google
      </button>
      <p class="divider">OU SE PREFERIR</p>
      <form id="loginForm">
        <div class="input-group">
          <input type="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="input-group">
          <input type="password" name="senha" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn-login">ENTRAR</button>
      </form>
      <div id="loginMessage" style="margin-top: 10px;"></div>
      <p class="register-text">Novo por aqui? <a href="#" onclick="abrirModalCadastro()">Crie sua conta.</a></p>
    </div>
  </div>

  <!-- Modal de Cadastro -->
  <div id="cadastroModal" class="modal" style="display: none;">
    <div class="modal-content" style="position: relative;">
      <span class="close2" onclick="fecharModalCadastro()">×</span>
      <h2>Criar Conta</h2>
      <form id="cadastroForm">
        <div class="input-group">
          <input type="text" name="nome" placeholder="Nome Completo" required>
        </div>
        <div class="input-group">
          <input type="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="input-group">
          <input type="password" name="senha" placeholder="Senha" required>
        </div>
        <select name="tipo" required>
          <option value="usuario">Usuário</option>
          <option value="admin">Administrador</option>
        </select>
        <button type="submit" class="btn-login">CADASTRAR</button>
      </form>
      <div id="cadastroMessage" style="margin-top: 10px;"></div>
    </div>
  </div>

  <!-- Produtos -->
  <div class="produtos-container">
    <?php foreach ($result as $row): ?>
      <div class="produto-card" data-id="<?php echo $row['id']; ?>">
        <div class="imagem-container">
          <img src="../uploads/<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
        </div>
        <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
        <p class="preco-antigo">R$ <?php echo number_format($row['preco'] * 1.1, 2, ',', '.'); ?></p>
        <p class="preco-atual">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
        <p class="parcelamento">ou até 10x de R$ <?php echo number_format($row['preco'] / 10, 2, ',', '.'); ?></p>
        <button class="btn-carrinho">
          <img src="../img/carrinho.png" alt="Adicionar ao Carrinho">
        </button>
        <?php if(isset($_SESSION["nome_usuario"]) && $_SESSION["tipo_usuario"] === "admin"): ?>
          <div class="botoes-admin">
            <button class="btn-editar" onclick="abrirModalEditar(<?php echo $row['id']; ?>)">Editar</button>
            <button class="btn-excluir" onclick="excluirProduto(<?php echo $row['id']; ?>)">Excluir</button>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <?php if(isset($_SESSION["nome_usuario"]) && $_SESSION["tipo_usuario"] === "admin"): ?>
      <div class="produto-card add-card" onclick="abrirModalAdicionar()">
        <img src="../img/mais.png" alt="Adicionar Produto" class="btn-add">
      </div>
    <?php endif; ?>
  </div>

  <!-- Modal de Adição de Produto -->
  <!-- Modal de Adição de Produto -->
<div id="modalAdicionar" class="modal-adicionar">
  <div class="modal-adicionar-conteudo">
    <span class="close" onclick="fecharModalAdicionar()">×</span>
    <h2 class="modal-adicionar-titulo">Adicionar Novo Produto</h2>
    <form id="formAdicionar" class="form-adicionar" enctype="multipart/form-data">
      <div class="form-grupo">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>
      </div>

      <div class="form-grupo">
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>
      </div>

      <div class="form-grupo">
        <label for="preco">Preço (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" required>
      </div>

      <div class="form-grupo">
        <div class="upload-imagem">
          <input type="file" id="imagem" name="imagem" accept="image/*" required>
          <span>Clique para selecionar uma imagem</span>
          <small>Formatos suportados: JPG, PNG (Max. 2MB)</small>
        </div>
      </div>

      <button type="submit" class="btn-adicionar">Adicionar Produto</button>
    </form>
    <div id="mensagemStatus"></div>
  </div>
</div>

  <!-- Modal de Edição de Produto -->
  <div id="modalEditar" class="modal">
    <div class="modal-content">
      <span class="close" onclick="fecharModalEditar()">×</span>
      <h2>Editar Produto</h2>
      <form id="formEditar">
        <input type="hidden" id="editar-id" name="id">
        <input type="text" id="editar-nome" name="nome" placeholder="Nome do Produto" required>
        <textarea id="editar-descricao" name="descricao" placeholder="Descrição" required></textarea>
        <input type="number" id="editar-preco" name="preco" step="0.01" placeholder="Preço" required>
        <input type="file" name="imagem" accept="image/*">
        <button class="btn-submit" type="submit">Salvar</button>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container-footer">
      <div class="footer-column">
        <h3>Departamentos</h3>
        <ul>
          <li>Flores Naturais</li>
          <li>Buquês</li>
          <li>Arranjos</li>
          <li>Plantas Ornamentais</li>
          <li>Vasos e Cachepôs</li>
          <li>Presentes</li>
          <li>Jardinagem</li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Novidades e Promoções</h3>
        <ul>
          <li>Blog Floral</li>
          <li>Assinatura de Flores</li>
          <li>Descontos Especiais</li>
          <li>Novas Coleções</li>
          <li>Promoções Sazonais</li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Institucional</h3>
        <ul>
          <li>Sobre a Nossa Floricultura</li>
          <li>Nossa Missão</li>
          <li>Política de Privacidade</li>
          <li>Trabalhe Conosco</li>
          <li>Contato</li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Atendimento</h3>
        <p>Horário de atendimento:<br>
          Segunda a Sexta: 08h às 20h<br>
          Sábado: 08h às 15h<br>
          Domingos e feriados: fechado</p>
        <p>Endereço: Rua das Rosas, 123 - Centro - Cidade/UF</p>
      </div>
      <div class="footer-column">
        <h3>Redes Sociais</h3>
        <div class="redes-sociais">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </footer>
  <script>
  console.log('Teste de JavaScript funcionando!');
  
  // Teste simples do carrossel
  if (document.querySelector('.carousel')) {
    console.log('Elemento do carrossel encontrado no DOM');
  } else {
    console.error('Elemento do carrossel NÃO encontrado');
  }
  
  // Teste simples do login
  if (document.getElementById('loginForm')) {
    console.log('Formulário de login encontrado');
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      console.log('Formulário submetido - JavaScript funcionando!');
    });
  } else {
    console.error('Formulário de login não encontrado');
  }
</script>
  <!-- No final do body -->
<script type="module" src="../js/principal.js"></script>
</body>
</html>