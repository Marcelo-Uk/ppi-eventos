<?php
// Exibir erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Subindo dois níveis para acessar o arquivo database.php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $userId = $_POST['id'];

        // Verificar o ID do usuário (para debug)
        echo "ID do usuário: " . $userId;

        // Deletar o usuário usando PDO
        $deleteQuery = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirecionar após a exclusão
            header("Location: /eventos/app/views/admin/ver_usuarios.php");
            exit;
        } else {
            echo "Erro ao deletar o usuário.";
        }
    } else {
        echo "ID do usuário não fornecido.";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
