<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'eventos';
    private $username = 'postgres';
    private $password = 'aluno';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

// Criando a instância de conexão
$database = new Database();
$conn = $database->getConnection();
