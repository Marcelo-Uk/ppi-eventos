<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['id'];

    $query = "INSERT INTO participacoes (user_id, evento_id) VALUES (:user_id, :evento_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':evento_id', $eventId);

    if ($stmt->execute()) {
        header("Location: /eventos/app/views/user/ver_eventos.php");
        exit;
    } else {
        echo "Erro ao participar do evento.";
    }
}
?>
