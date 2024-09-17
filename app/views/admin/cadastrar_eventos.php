<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];

    if (!empty($nome) && !empty($data) && !empty($local)) {
        // Usando a conexão do arquivo database.php
        $query = "INSERT INTO eventos (nome, data, local, descricao) VALUES ($1, $2, $3, $4)";
        $result = pg_query_params($conn, $query, array($nome, $data, $local, $descricao));

        if ($result) {
            $message = "Evento cadastrado com sucesso!";
            // Limpar campos após inserção
            $_POST = array();
        } else {
            $message = "Erro ao cadastrar evento.";
        }
    } else {
        $message = "Preencha todos os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Evento</title>
    <link rel="stylesheet" href="/eventos/public/css/style.css">
</head>
<body>
    <header>
        <img src="/eventos/assets/logo.png" alt="Logo" width="100">
        <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
    </header>

    <div class="container">
        <h1>Formulário para Cadastrar Evento</h1>

        <form method="POST" action="">
            <input type="text" name="nome" placeholder="Nome do Evento" value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>" required>
            <input type="date" name="data" value="<?php echo isset($_POST['data']) ? htmlspecialchars($_POST['data']) : ''; ?>" required>
            <input type="text" name="local" placeholder="Local do Evento" value="<?php echo isset($_POST['local']) ? htmlspecialchars($_POST['local']) : ''; ?>" required>
            <textarea name="descricao" placeholder="Descrição do Evento"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 Sistema Eventos - PPI</p>
    </footer>
</body>
</html>
