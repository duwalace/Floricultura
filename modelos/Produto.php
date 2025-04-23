<?php
require_once __DIR__ . '/../config/global.php'; // Inclui o arquivo global
require_once BASE_PATH . '/config/conexao.php'; // Inclui o arquivo de conexão

class Produto {
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $imagem;
    
    public function __construct($id = null, $nome = null, $descricao = null, $preco = null, $imagem = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }
    
    // Getters e Setters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getDescricao() { return $this->descricao; }
    public function getPreco() { return $this->preco; }
    public function getImagem() { return $this->imagem; }
    
    public function setId($id) { $this->id = $id; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setPreco($preco) { $this->preco = $preco; }
    public function setImagem($imagem) { $this->imagem = $imagem; }
    
    // Métodos CRUD
    public function cadastrar() {
        try {
            $conn = Conexao::obterConexao();
            $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:nome, :descricao, :preco, :imagem)");
            
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':preco', $this->preco);
            $stmt->bindParam(':imagem', $this->imagem);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar produto: " . $e->getMessage();
            return false;
        }
    }
    
    public static function listarTodos() {
        try {
            $conn = Conexao::obterConexao();
            $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY nome");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar produtos: " . $e->getMessage();
            return [];
        }
    }
    
    public static function buscarPorId($id) {
        try {
            $conn = Conexao::obterConexao();
            $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produto: " . $e->getMessage();
            return null;
        }
    }
    
    public function atualizar() {
        try {
            $conn = Conexao::obterConexao();
            
            // Se a imagem foi alterada
            if ($this->imagem) {
                $stmt = $conn->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id = :id");
                $stmt->bindParam(':imagem', $this->imagem);
            } else {
                $stmt = $conn->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id");
            }
            
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':preco', $this->preco);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar produto: " . $e->getMessage();
            return false;
        }
    }
    
    public static function excluir($id) {
        try {
            $conn = Conexao::obterConexao();
            $stmt = $conn->prepare("DELETE FROM produtos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir produto: " . $e->getMessage();
            return false;
        }
    }
    
    public static function buscarPorNome($termo) {
        try {
            $conn = Conexao::obterConexao();
            $termo = "%$termo%";
            $stmt = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE :termo ORDER BY nome");
            $stmt->bindParam(':termo', $termo);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
            return [];
        }
    }
}
?>

