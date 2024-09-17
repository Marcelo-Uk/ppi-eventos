<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $eventId = $_POST['id'];

        // Deletar o evento
        $deleteQuery = "DELETE FROM eventos WHERE id = $1";
        $result = pg_query_params($conn, $deleteQuery, array($eventId));

        if ($result) {
            // Use um caminho absoluto para garantir que o redirecionamento funcione
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
