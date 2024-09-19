<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    
    // Consultar o evento com PDO
    $query = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Buscar o evento
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];
    $eventId = $_POST['id'];

    // Atualizar o evento com PDO
    $updateQuery = "UPDATE eventos SET nome = :nome, data = :data, local = :local, descricao = :descricao WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':local', $local);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
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
    <div class="main-container">
        <div class="main-container-header">
            <header>
                <img src="/eventos/assets/logo.png" alt="Logo" width="100">
                <a href="/eventos/app/views/admin/dashboard.php">Home</a>
                <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
            </header>
        </div>
        <div class="container">
            <h1>Editar Evento</h1>
            <form action="editar_evento.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id']); ?>">
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

        <div class="container-footer">
            <footer>
                <p>&copy; 2024 Sistema Eventos - PPI</p>
            </footer>
        </div>
    </div>
</body>
</html>
