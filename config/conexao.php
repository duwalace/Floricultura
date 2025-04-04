<?php
class Conexao {
    private static $instancia;
    
    public static function obterConexao() {
        if (!isset(self::$instancia)) {
            try {
                self::$instancia = new PDO(
                    'mysql:host=localhost;dbname=floricultura;charset=utf8',
                    'root',
                    '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
                die();
            }
        }
        return self::$instancia;
    }
}
?>

