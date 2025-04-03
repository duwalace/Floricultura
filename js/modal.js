// modules/modal.js - Gerenciamento de modais
export function initModals() {
    // Funções para abrir/fechar modais
    window.abrirModalLogin = function() {
      document.getElementById("loginModal").style.display = "flex";
    };
  
    window.fecharModal = function() {
      document.getElementById("loginModal").style.display = "none";
    };
  
    window.abrirModalCadastro = function() {
      document.getElementById("loginModal").style.display = "none";
      document.getElementById("cadastroModal").style.display = "flex";
    };
  
    window.fecharModalCadastro = function() {
      document.getElementById("cadastroModal").style.display = "none";
    };
  
    window.abrirCarrinho = function() {
      document.getElementById("carrinhoModal").style.display = "flex";
      atualizarCarrinho(); // Função do carrinho.js
    };
  
    window.fecharCarrinho = function() {
      document.getElementById("carrinhoModal").style.display = "none";
    };
  
    // Fechar modais ao clicar fora
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
      modal.addEventListener('click', function(e) {
        if (e.target === this) {
          this.style.display = 'none';
        }
      });
    });
  }