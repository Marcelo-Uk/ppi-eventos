<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $query = "SELECT * FROM eventos WHERE id = $1";
    $result = pg_query_params($conn, $query, array($eventId));
    $event = pg_fetch_assoc($result);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];
    $eventId = $_POST['id'];

    // Atualizar o evento no banco de dados
    $updateQuery = "UPDATE eventos SET nome = $1, data = $2, local = $3, descricao = $4 WHERE id = $5";
    $result = pg_query_params($conn, $updateQuery, array($nome, $data, $local, $descricao, $eventId));

    if ($result) {
        header("Location: /eventos/app/views/admin/ver_eventos.php");
        exit;
    } else {
        echo "Erro ao atualizar o evento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="/eventos/public/css/style.css">
</head>
<body>
    <header>
        <img src="/eventos/assets/logo.png" alt="Logo" width="100">
        <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
    </header>

    <div class="container">
        <h1>Editar Evento</h1>
        <form action="editar_evento.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
            <label for="nome">Nome do Evento:</label><br>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($event['nome']); ?>" required><br>
            
            <label for="data">Data:</label><br>
            <input type="date" name="data" value="<?php echo htmlspecialchars($event['data']); ?>" required><br>
            
            <label for="local">Local:</label><br>
            <input type="text" name="local" value="<?php echo htmlspecialchars($event['local']); ?>" required><br>
            
            <label for="descricao">Descrição:</label><br>
            <textarea name="descricao" required><?php echo htmlspecialchars($event['descricao']); ?></textarea><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Sistema Eventos - PPI</p>
    </footer>
</body>
</html>
