// Importação dos módulos
import { initAuth } from './auth.js';
import { initCadastro } from './cadastro.js';
import { initCarousel } from './carousel.js';
import { initCarrinho } from './carrinho.js';
import { initLogin } from './login.js';
import { initModal } from './modal.js';
import { initProdutos } from './produtos.js';

// Configurações globais
const config = {
  debugMode: true, // Altere para false em produção
  apiBaseUrl: 'https://sua-api.com/v1'
};

// Função principal de inicialização
function initApp() {
  try {
    if (config.debugMode) {
      console.log('Inicializando aplicação...');
    }

    // Inicializa módulos
    initAuth();
    initCarousel();
    initModal();
    initLogin();
    initCadastro();
    initCarrinho();
    initProdutos();

    // Verifica se o usuário está logado
    const usuarioLogado = localStorage.getItem('usuarioLogado');
    if (usuarioLogado && config.debugMode) {
      console.log('Usuário logado:', JSON.parse(usuarioLogado));
    }

    if (config.debugMode) {
      console.log('Aplicação inicializada com sucesso!');
    }
  } catch (error) {
    console.error('Erro na inicialização:', error);
    // Aqui você pode adicionar tratamento de erro personalizado
  }
}

// Eventos globais
document.addEventListener('DOMContentLoaded', initApp);

// Funções utilitárias globais (opcional)
export function showLoading() {
  document.getElementById('loading').style.display = 'block';
}

export function hideLoading() {
  document.getElementById('loading').style.display = 'none';
}

// Exportações para uso em outros módulos (se necessário)
export {
  config,
  initApp
};