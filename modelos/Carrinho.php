<?php
require_once 'config/conexao.php';
require_once 'modelos/Produto.php';

class ItemCarrinho {
    private $produto;
    private $quantidade;
    
    public function __construct($produto, $quantidade = 1) {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }
    
    public function getProduto() { return $this->produto; }
    public function getQuantidade() { return $this->quantidade; }
    
    public function setQuantidade($quantidade) { 
        $this->quantidade = $quantidade; 
    }
    
    public function getSubtotal() {
        return $this->produto['preco'] * $this->quantidade;
    }
}

class Carrinho {
    private $itens = [];
    
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['carrinho'])) {
            $this->itens = $_SESSION['carrinho'];
        }
    }
    
    public function adicionarItem($produtoId, $quantidade = 1) {
        $produto = Produto::buscarPorId($produtoId);
        
        if (!$produto) {
            return false;
        }
        
        // Verifica se o produto já está no carrinho
        if (isset($this->itens[$produtoId])) {
            $this->itens[$produtoId]->setQuantidade(
                $this->itens[$produtoId]->getQuantidade() + $quantidade
            );
        } else {
            $this->itens[$produtoId] = new ItemCarrinho($produto, $quantidade);
        }
        
        $this->salvar();
        return true;
    }
    
    public function removerItem($produtoId) {
        if (isset($this->itens[$produtoId])) {
            unset($this->itens[$produtoId]);
            $this->salvar();
            return true;
        }
        
        return false;
    }
    
    public function atualizarQuantidade($produtoId, $quantidade) {
        if (isset($this->itens[$produtoId])) {
            if ($quantidade <= 0) {
                return $this->removerItem($produtoId);
            }
            
            $this->itens[$produtoId]->setQuantidade($quantidade);
            $this->salvar();
            return true;
        }
        
        return false;
    }
    
    public function getItens() {
        return $this->itens;
    }
    
    public function getTotal() {
        $total = 0;
        
        foreach ($this->itens as $item) {
            $total += $item->getSubtotal();
        }
        
        return $total;
    }
    
    public function getQuantidadeItens() {
        $quantidade = 0;
        
        foreach ($this->itens as $item) {
            $quantidade += $item->getQuantidade();
        }
        
        return $quantidade;
    }
    
    public function limpar() {
        $this->itens = [];
        $this->salvar();
    }
    
    private function salvar() {
        $_SESSION['carrinho'] = $this->itens;
    }
}
?>

