// modules/auth.js - Autenticação/login
export function initAuth() {
    // Formulário de login
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      
      fetch('../php/login.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        const messageEl = document.getElementById('loginMessage');
        messageEl.textContent = data.mensagem;
        messageEl.style.color = data.sucesso ? 'green' : 'red';
        
        if (data.sucesso) {
          setTimeout(() => window.location.reload(), 1500);
        }
      });
    });
  
    // Formulário de cadastro
    document.getElementById('cadastroForm')?.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      
      fetch('../php/cadastro.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        const messageEl = document.getElementById('cadastroMessage');
        messageEl.textContent = data.mensagem;
        messageEl.style.color = data.sucesso ? 'green' : 'red';
        
        if (data.sucesso) {
          setTimeout(() => {
            fecharModalCadastro();
            abrirModalLogin();
          }, 1500);
        }
      });
    });
  }