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
        $eventId = $_POST['id'];

        // Verificar o ID do evento (para debug)
        echo "ID do evento: " . $eventId;

        // Deletar o evento usando PDO
        $deleteQuery = "DELETE FROM eventos WHERE id = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirecionar após a exclusão
            header("Location: /eventos/app/views/admin/ver_eventos.php");
            exit;
        } else {
            echo "Erro ao deletar o evento.";
        }
    } else {
        echo "ID do evento não fornecido.";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
