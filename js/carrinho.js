// modules/carrinho.js - Gerenciamento do carrinho
let carrinho = [];

export function initCarrinho() {
  // Funções globais
  window.adicionarAoCarrinho = function(id, nome, preco, imagem) {
    const produto = { id, nome, preco, imagem };
    carrinho.push(produto);
    atualizarCarrinho();
  };

  window.atualizarCarrinho = function() {
    const carrinhoItens = document.getElementById("carrinhoItens");
    if (!carrinhoItens) return;
    
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
  };

  window.finalizarCompra = function() {
    if (carrinho.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }
    alert("Compra finalizada com sucesso!");
    carrinho = [];
    atualizarCarrinho();
    fecharCarrinho();
  };

  // Event listeners para produtos
  document.querySelectorAll('.produto-card').forEach(card => {
    card.addEventListener('click', (e) => {
      // Evita adicionar ao carrinho quando clica nos botões de admin
      if (e.target.closest('.botoes-admin')) return;
      
      const id = card.dataset.id;
      const nome = card.querySelector('h3').innerText;
      const preco = parseFloat(card.querySelector('.preco-atual').innerText.replace('R$ ', '').replace(',', '.'));
      const imagem = card.querySelector('img').src.split('/').pop();
      adicionarAoCarrinho(id, nome, preco, imagem);
    });
  });
}