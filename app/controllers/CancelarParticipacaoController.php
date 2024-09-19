<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['id'];

    $query = "DELETE FROM participacoes WHERE user_id = :user_id AND evento_id = :evento_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':evento_id', $eventId);

    if ($stmt->execute()) {
        header("Location: /eventos/app/views/user/ver_eventos.php");
        exit;
    } else {
        echo "Erro ao cancelar participação no evento.";
    }
}
?>
