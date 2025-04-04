<?php
require_once '../config/conexao.php';

class Usuario {
  private $id;
  private $nome;
  private $email;
  private $senha;
  private $tipo;
  
  public function __construct($id = null, $nome = null, $email = null, $senha = null, $tipo = 'usuario') {
      $this->id = $id;
      $this->nome = $nome;
      $this->email = $email;
      $this->senha = $senha;
      $this->tipo = $tipo;
  }
  
  // Getters e Setters
  public function getId() { return $this->id; }
  public function getNome() { return $this->nome; }
  public function getEmail() { return $this->email; }
  public function getSenha() { return $this->senha; }
  public function getTipo() { return $this->tipo; }
  
  public function setId($id) { $this->id = $id; }
  public function setNome($nome) { $this->nome = $nome; }
  public function setEmail($email) { $this->email = $email; }
  public function setSenha($senha) { $this->senha = $senha; }
  public function setTipo($tipo) { $this->tipo = $tipo; }
  
  // Métodos CRUD
  public function cadastrar() {
      try {
          $conn = Conexao::obterConexao();
          $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)");
          
          $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);
          
          $stmt->bindParam(':nome', $this->nome);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':senha', $senhaHash);
          $stmt->bindParam(':tipo', $this->tipo);
          
          return $stmt->execute();
      } catch (PDOException $e) {
          echo "Erro ao cadastrar: " . $e->getMessage();
          return false;
      }
  }
  
  public function autenticar($email, $senha) {
      // Verificação especial para o admin
      if ($email === 'admin@floricultura.com' && $senha === 'admin123') {
          $this->id = 1;
          $this->nome = 'Administrador';
          $this->email = 'admin@floricultura.com';
          $this->senha = 'admin123';
          $this->tipo = 'admin';
          return true;
      }
      
      try {
          $conn = Conexao::obterConexao();
          $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          
          if ($stmt->rowCount() > 0) {
              $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
              
              if (password_verify($senha, $usuario['senha'])) {
                  $this->id = $usuario['id'];
                  $this->nome = $usuario['nome'];
                  $this->email = $usuario['email'];
                  $this->senha = $usuario['senha'];
                  $this->tipo = $usuario['tipo'];
                  return true;
              }
          }
          
          return false;
      } catch (PDOException $e) {
          echo "Erro na autenticação: " . $e->getMessage();
          return false;
      }
  }
  
  public static function listarTodos() {
      try {
          $conn = Conexao::obterConexao();
          $stmt = $conn->prepare("SELECT * FROM usuarios ORDER BY nome");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          echo "Erro ao listar usuários: " . $e->getMessage();
          return [];
      }
  }
  
  public static function buscarPorId($id) {
      try {
          $conn = Conexao::obterConexao();
          $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          
          return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          echo "Erro ao buscar usuário: " . $e->getMessage();
          return null;
      }
  }
  
  public function atualizar() {
      try {
          $conn = Conexao::obterConexao();
          
          // Se a senha foi alterada, faz o hash
          if (strlen($this->senha) < 60) { // Verifica se não é um hash
              $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);
              $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, tipo = :tipo WHERE id = :id");
              $stmt->bindParam(':senha', $senhaHash);
          } else {
              $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
          }
          
          $stmt->bindParam(':nome', $this->nome);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':tipo', $this->tipo);
          $stmt->bindParam(':id', $this->id);
          
          return $stmt->execute();
      } catch (PDOException $e) {
          echo "Erro ao atualizar usuário: " . $e->getMessage();
          return false;
      }
  }
  
  public static function excluir($id) {
      try {
          $conn = Conexao::obterConexao();
          $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
          $stmt->bindParam(':id', $id);
          return $stmt->execute();
      } catch (PDOException $e) {
          echo "Erro ao excluir usuário: " . $e->getMessage();
          return false;
      }
  }
  
  public static function emailExiste($email, $excluirId = null) {
      try {
          $conn = Conexao::obterConexao();
          
          if ($excluirId) {
              $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email AND id != :id");
              $stmt->bindParam(':id', $excluirId);
          } else {
              $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
          }
          
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          
          return $stmt->fetchColumn() > 0;
      } catch (PDOException $e) {
          echo "Erro ao verificar email: " . $e->getMessage();
          return false;
      }
  }
}
?>

