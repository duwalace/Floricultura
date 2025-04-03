// modules/produtos.js - Funcionalidades de produtos
export function initProdutos() {
  // Elementos do DOM
  const mensagemStatus = document.getElementById('mensagemStatus');
  const formAdicionar = document.getElementById('formAdicionar');
  const formEditar = document.getElementById('formEditar');

  // Funções de modal
  window.abrirModalAdicionar = () => {
      document.getElementById("modalAdicionar").style.display = "flex";
      mensagemStatus.innerHTML = ''; // Limpa mensagens anteriores
  };

  window.fecharModalAdicionar = () => {
      document.getElementById("modalAdicionar").style.display = "none";
  };

  window.abrirModalEditar = (id) => {
      fetch(`../php/buscar_produto.php?id=${id}`)
          .then(response => response.json())
          .then(data => {
              if (data.sucesso) {
                  document.getElementById('editar-id').value = data.produto.id;
                  document.getElementById('editar-nome').value = data.produto.nome;
                  document.getElementById('editar-descricao').value = data.produto.descricao;
                  document.getElementById('editar-preco').value = data.produto.preco;
                  document.getElementById('modalEditar').style.display = 'flex';
                  mensagemStatus.innerHTML = ''; // Limpa mensagens anteriores
              }
          });
  };

  window.fecharModalEditar = () => {
      document.getElementById("modalEditar").style.display = "none";
  };

  // Funções CRUD
  window.excluirProduto = (id) => {
      if (confirm("Tem certeza que deseja excluir este produto?")) {
          fetch(`../php/excluir_produto.php?id=${id}`, { method: 'DELETE' })
              .then(response => response.json())
              .then(data => {
                  if (data.sucesso) {
                      window.location.reload();
                  }
              });
      }
  };

  // Event Listeners
  if (formAdicionar) {
      formAdicionar.addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);

          fetch('../php/adicionar_produto.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.sucesso) {
                  mensagemStatus.style.color = 'green';
                  mensagemStatus.innerHTML = data.mensagem;
                  setTimeout(() => {
                      fecharModalAdicionar();
                      window.location.reload();
                  }, 1500);
              } else {
                  mensagemStatus.style.color = 'red';
                  mensagemStatus.innerHTML = data.erro;
              }
          })
          .catch(error => {
              mensagemStatus.style.color = 'red';
              mensagemStatus.innerHTML = 'Erro na comunicação com o servidor';
          });
      });
  }

  if (formEditar) {
      formEditar.addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);

          fetch('../php/editar_produto.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.sucesso) {
                  mensagemStatus.style.color = 'green';
                  mensagemStatus.innerHTML = 'Produto atualizado com sucesso!';
                  setTimeout(() => {
                      window.location.reload();
                  }, 1500);
              } else {
                  mensagemStatus.style.color = 'red';
                  mensagemStatus.innerHTML = data.erro;
              }
          })
          .catch(error => {
              mensagemStatus.style.color = 'red';
              mensagemStatus.innerHTML = 'Erro na comunicação com o servidor';
          });
      });
  }
}