
<?php

class Conexao
{
    private static ?PDO $conexao = null;

    public static function conectar(): PDO
    {
        if (self::$conexao === null) {
            $host = 'localhost';
            $banco = 'tasklist';
            $usuario = 'root';
            $senha = '';

            try {
                self::$conexao = new PDO(
                    "mysql:host=$host;dbname=$banco;charset=utf8mb4",
                    $usuario,
                    $senha,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
            }
        }

        return self::$conexao;
    }
}
