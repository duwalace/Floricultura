<?php
session_start();

include '../php/conexao.php';

// Define o nome do usuário, caso não esteja logado será "Visitante"
$nome_usuario = isset($_SESSION["nome_usuario"]) ? $_SESSION["nome_usuario"] : "Visitante";
// Verifica se o usuário está logado
$usuarioLogado = isset($_SESSION["nome_usuario"]) && !empty($_SESSION["nome_usuario"]);

// Buscando produtos do banco
$result = []; // Inicializa $result como array vazio por padrão
try {
    $sql = "SELECT * FROM produtos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em vez de die(), loga o erro ou exibe uma mensagem amigável
    error_log("Erro na consulta: " . $e->getMessage()); // Loga o erro no arquivo de log
    $result = []; // Garante que $result seja um array vazio em caso de erro
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
  <script src="../js/login.js" defer></script>
  <script src="../js/cadastro.js" defer></script>
</head>

<body>
  <!-- Cabeçalho -->
  <header class="container">
    <div class="brand">
      <a href="../principal.php"><img src="../img/logo.png" width="165" height="165" alt="Logo Viva-Flor"></a>
    </div>

    <nav class="menu">
      <?php if ($usuarioLogado): ?>
        <span>Olá, <?php echo htmlspecialchars($nome_usuario); ?></span>

        <!-- Botão de Logout -->
        <form action="../php/logout.php" method="post">
          <button type="submit" class="logout-btn" aria-label="Sair">
            <img src="../img/sair.png" alt="Ícone de logout">
          </button>
        </form>

        <!-- Ícone do Carrinho -->
        <a href="#" class="carrinho-link" onclick="abrirCarrinho()" aria-label="Abrir carrinho">
          <img src="../img/carrinho.png" alt="Ícone de carrinho">
        </a>

      <?php else: ?>
        <a href="#" class="login-btn" onclick="abrirModalLogin()" aria-label="Entrar ou cadastrar-se">
          <img src="../img/perfil.png" alt="Ícone de usuário"> 
          <span>ENTRE OU <br> CADASTRE-SE</span>
        </a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Modal do Carrinho -->
  <dialog id="carrinhoModal" class="modal">
    <div class="modal-content">
      <button class="close" onclick="fecharCarrinho()" aria-label="Fechar">×</button>
      <h2>Carrinho de Compras</h2>
      <div id="carrinhoItens">
        <!-- Itens do carrinho serão adicionados aqui -->
      </div>
      <button class="btn-submit" onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
  </dialog>

  <!-- Modal de Login -->
  <dialog id="loginModal" class="modal">
    <div class="modal-content">
      <div class="close-container">
        <button class="close" onclick="fecharModal()" aria-label="Fechar">×</button>
      </div>
      <h2>Entre na sua conta</h2>
      <button class="google-login">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Logo do Google">
        Entrar com Google
      </button>
      <p class="divider">Ou se preferir</p>
      <form id="loginForm">
        <div class="input-group">
          <input type="email" name="email" placeholder="E-mail" required aria-label="E-mail">
        </div>
        <div class="input-group">
          <input type="password" name="senha" placeholder="Senha" required aria-label="Senha">
        </div>
        <button type="submit" class="btn-login">Entrar</button>
      </form>
      <div id="loginMessage" aria-live="polite"></div>
      <p class="register-text">Novo por aqui? <a href="#" onclick="abrirModalCadastro()">Crie sua conta.</a></p>
    </div>
  </dialog>

  <!-- Modal de Cadastro -->
  <dialog id="cadastroModal" class="modal">
    <div class="modal-content">
      <button class="close2" onclick="fecharModalCadastro()" aria-label="Fechar">×</button>
      <h2>Criar Conta</h2>
      <form id="cadastroForm">
        <div class="input-group">
          <input type="text" name="nome" placeholder="Nome Completo" required aria-label="Nome Completo">
        </div>
        <div class="input-group">
          <input type="email" name="email" placeholder="E-mail" required aria-label="E-mail">
        </div>
        <div class="input-group">
          <input type="password" name="senha" placeholder="Senha" required aria-label="Senha">
        </div>
        <select name="tipo" required aria-label="Tipo de usuário">
          <option value="usuario">Usuário</option>
          <option value="admin">Administrador</option>
        </select>
        <button type="submit" class="btn-login">Cadastrar</button>
      </form>
      <div id="cadastroMessage" aria-live="polite"></div>
    </div>
  </dialog>

  <!-- Navegação de Categorias -->
  <nav class="container1">
    <ul class="palavras">
      <li><a href="../Cactos/Cactos.php">Cactos</a></li>
      <li><a href="../Buque/Buque.php">Buquê de Flores</a></li>
      <li><a href="../Floresemvaso/Floresemvaso.php">Flores em Vaso</a></li>
      <li><a href="../Arranjodeflores/Arranjodeflores.php">Arranjo de Flores</a></li>
      <li><a href="../Ocasioes/Ocasioes.php">Ocasiões</a></li>
      <li><a href="../Suculentas/Suculentas.php">Suculentas</a></li>
      <li><a href="../Cesta/Cesta.php">Cestas</a></li>
    </ul>
  </nav>

  <!-- Conteúdo Principal -->
  <main>
    <section class="produtos-container">
      <?php if (!empty($result)): ?>
        <?php foreach ($result as $row): ?>
          <article class="produto-card" data-id="<?php echo $row['id']; ?>">
            <div class="imagem-container">
              <img src="../uploads/<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
            </div>
            <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
            <p class="preco-antigo">R$ <?php echo number_format($row['preco'] * 1.1, 2, ',', '.'); ?></p>
            <p class="preco-atual">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
            <p class="parcelamento">ou até 10x de R$ <?php echo number_format($row['preco'] / 10, 2, ',', '.'); ?></p>
            <button class="btn-carrinho" onclick="adicionarAoCarrinho(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nome']); ?>', <?php echo $row['preco']; ?>, '<?php echo htmlspecialchars($row['imagem']); ?>')" aria-label="Adicionar ao carrinho">
              <img src="../img/carrinho.png" alt="Ícone de carrinho">
            </button>
            <?php if (isset($_SESSION["nome_usuario"]) && $_SESSION["tipo_usuario"] === "admin"): ?>
              <div class="botoes-admin">
                <button class="btn-editar" onclick="abrirModalEditar(<?php echo $row['id']; ?>)">Editar</button>
                <button class="btn-excluir" onclick="excluirProduto(<?php echo $row['id']; ?>)">Excluir</button>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Nenhum produto encontrado.</p>
      <?php endif; ?>
      <?php if (isset($_SESSION["nome_usuario"]) && $_SESSION["tipo_usuario"] === "admin"): ?>
        <article class="produto-card add-card" onclick="abrirModalAdicionar()">
          <img src="../img/mais.png" alt="Adicionar Produto" class="btn-add">
        </article>
      <?php endif; ?>
    </section>

    <!-- Modal de Adição de Produto -->
    <dialog id="modalAdicionar" class="modal">
      <div class="modal-content">
        <button class="close" onclick="fecharModalAdicionar()" aria-label="Fechar">×</button>
        <h2>Adicionar Produto</h2>
        <form id="formAdicionar" onsubmit="adicionarProduto(event)">
          <input type="text" name="nome" placeholder="Nome do Produto" required aria-label="Nome do Produto">
          <textarea name="descricao" placeholder="Descrição" required aria-label="Descrição"></textarea>
          <input type="number" name="preco" step="0.01" placeholder="Preço" required aria-label="Preço">
          <input type="file" name="imagem" accept="image/*" required aria-label="Imagem do Produto">
          <button class="btn-submit" type="submit">Adicionar</button>
        </form>
      </div>
    </dialog>

    <!-- Modal de Edição de Produto -->
    <dialog id="modalEditar" class="modal">
      <div class="modal-content">
        <button class="close" onclick="fecharModalEditar()" aria-label="Fechar">×</button>
        <h2>Editar Produto</h2>
        <form id="formEditar" onsubmit="editarProduto(event)">
          <input type="hidden" id="editar-id" name="id">
          <input type="text" id="editar-nome" name="nome" placeholder="Nome do Produto" required aria-label="Nome do Produto">
          <textarea id="editar-descricao" name="descricao" placeholder="Descrição" required aria-label="Descrição"></textarea>
          <input type="number" id="editar-preco" name="preco" step="0.01" placeholder="Preço" required aria-label="Preço">
          <input type="file" name="imagem" accept="image/*" aria-label="Nova Imagem (opcional)">
          <button class="btn-submit" type="submit">Salvar</button>
        </form>
      </div>
    </dialog>
  </main>

  <!-- Rodapé -->
  <footer>
    <div class="container-footer">
      <section class="footer-column">
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
      </section>
      <section class="footer-column">
        <h3>Novidades e Promoções</h3>
        <ul>
          <li>Blog Floral</li>
          <li>Assinatura de Flores</li>
          <li>Descontos Especiais</li>
          <li>Novas Coleções</li>
          <li>Promoções Sazonais</li>
        </ul>
      </section>
      <section class="footer-column">
        <h3>Institucional</h3>
        <ul>
          <li>Sobre a Nossa Floricultura</li>
          <li>Nossa Missão</li>
          <li>Política de Privacidade</li>
          <li>Trabalhe Conosco</li>
          <li>Contato</li>
        </ul>
      </section>
      <section class="footer-column">
        <h3>Atendimento</h3>
        <p>Horário de atendimento:<br>
          Segunda a Sexta: 08h às 20h<br>
          Sábado: 08h às 15h<br>
          Domingos e feriados: fechado</p>
        <p>Endereço: Rua das Rosas, 123 - Centro - Cidade/UF</p>
      </section>
      <section class="footer-column">
        <h3>Redes Sociais</h3>
        <div class="redes-sociais">
          <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
          <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </section>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    function abrirModalLogin() {
      document.getElementById("loginModal").style.display = "flex";
    }

    function fecharModal() {
      document.getElementById("loginModal").style.display = "none";
    }

    function abrirModalCadastro() {
      document.getElementById("cadastroModal").style.display = "flex";
    }

    function fecharModalCadastro() {
      document.getElementById("cadastroModal").style.display = "none";
    }

    function abrirModalAdicionar() {
      document.getElementById("modalAdicionar").style.display = "flex";
    }

    function fecharModalAdicionar() {
      document.getElementById("modalAdicionar").style.display = "none";
    }

    function adicionarProduto(event) {
      event.preventDefault();
      const formData = new FormData(document.getElementById('formAdicionar'));
      fetch('../php/adicionar_produto.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          alert(data.mensagem);
          window.location.href = '../html/principal.php';
        } else {
          alert("Erro: " + data.erro);
        }
      })
      .catch(error => {
        console.error("Erro:", error);
        alert("Erro ao adicionar o produto.");
      });
    }

    function excluirProduto(id) {
      if (confirm("Tem certeza que deseja excluir este produto?")) {
        fetch(`../php/excluir_produto.php?id=${id}`, {
          method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
          if (data.sucesso) {
            alert("Produto excluído com sucesso!");
            window.location.reload();
          } else {
            alert("Erro ao excluir o produto.");
          }
        })
        .catch(error => {
          console.error("Erro:", error);
          alert("Erro ao excluir o produto.");
        });
      }
    }

    function abrirModalEditar(id) {
      fetch(`../php/buscar_produto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
          if (data.sucesso) {
            document.getElementById('editar-id').value = data.produto.id;
            document.getElementById('editar-nome').value = data.produto.nome;
            document.getElementById('editar-descricao').value = data.produto.descricao;
            document.getElementById('editar-preco').value = data.produto.preco;
            document.getElementById('modalEditar').style.display = 'flex';
          } else {
            alert("Erro ao carregar os dados do produto.");
          }
        })
        .catch(error => {
          console.error("Erro:", error);
          alert("Erro ao carregar os dados do produto.");
        });
    }

    function editarProduto(event) {
      event.preventDefault();
      const formData = new FormData(document.getElementById('formEditar'));
      fetch('../php/editar_produto.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          alert("Produto editado com sucesso!");
          window.location.href = '../html/principal.php';
        } else {
          alert("Erro ao editar o produto: " + data.erro);
        }
      })
      .catch(error => {
        console.error("Erro:", error);
        alert("Erro ao editar o produto.");
      });
    }

    let carrinho = [];

    function abrirCarrinho() {
      document.getElementById("carrinhoModal").style.display = "flex";
      atualizarCarrinho();
    }

    function fecharCarrinho() {
      document.getElementById("carrinhoModal").style.display = "none";
    }

    function adicionarAoCarrinho(id, nome, preco, imagem) {
      const produto = { id, nome, preco, imagem };
      carrinho.push(produto);
      atualizarCarrinho();
      alert(`${nome} foi adicionado ao carrinho!`);
    }

    function atualizarCarrinho() {
      const carrinhoItens = document.getElementById("carrinhoItens");
      carrinhoItens.innerHTML = "";
      carrinho.forEach(item => {
        const itemDiv = document.createElement("div");
        itemDiv.className = "carrinho-item";
        itemDiv.innerHTML = `
          <img src="../uploads/${item.imagem}" alt="${item.nome}" width="50">
          <h3>${item.nome}</h3>
          <p>R$ ${item.preco.toFixed(2)}</p>
        `;
        carrinhoItens.appendChild(itemDiv);
      });
    }

    function finalizarCompra() {
      if (carrinho.length === 0) {
        alert("Seu carrinho está vazio!");
        return;
      }
      alert("Compra finalizada com sucesso!");
      carrinho = [];
      atualizarCarrinho();
      fecharCarrinho();
    }

    document.querySelectorAll('.produto-card').forEach(card => {
      card.addEventListener('click', () => {
        const id = card.dataset.id;
        const nome = card.querySelector('h3').innerText;
        const preco = parseFloat(card.querySelector('.preco-antigo').innerText.replace('R$ ', '').replace(',', '.'));
        const imagem = card.querySelector('img').src.split('/').pop();
        adicionarAoCarrinho(id, nome, preco, imagem);
      });
    });
  </script>
</body>
</html>