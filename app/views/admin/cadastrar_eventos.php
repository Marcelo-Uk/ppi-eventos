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
        // Usando a conexão do arquivo database.php com PDO
        $query = "INSERT INTO eventos (nome, data, local, descricao) VALUES (:nome, :data, :local, :descricao)";
        $stmt = $conn->prepare($query);
        
        // Vincular parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':descricao', $descricao);
        
        // Executar a query e verificar se funcionou
        if ($stmt->execute()) {
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
    <div class="main-container">
        <div class="main-container-header">
            <div class="header-logo">
                <img class="img-logo" src="/eventos/assets/logo.png" alt="Logo">
            </div>
            <div class="header-botoes">
                <button class="button-header" onclick="window.location.href='/eventos/app/views/admin/dashboard.php'">Home</button>
                <button class="button-header" onclick="window.location.href='/eventos/app/controllers/LogoutController.php'">Sair</button>
            </div>

        </div>
        <div class="container-forms-main">

            <div class="container-forms">
                <h1>Preencha os Dados do Evento</h1>

                <form method="POST" action="">
                    <label for="nome">Nome do Evento</label>
                    <input type="text" name="nome" placeholder="Nome do Evento" value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>" required>

                    <label for="data">Data</label>
                    <input type="date" name="data" value="<?php echo isset($_POST['data']) ? htmlspecialchars($_POST['data']) : ''; ?>" required>

                    <label for="local">Local</label>
                    <input type="text" name="local" placeholder="Local do Evento" value="<?php echo isset($_POST['local']) ? htmlspecialchars($_POST['local']) : ''; ?>" required>

                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" placeholder="Descrição do Evento"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>

                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>


        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <div class="container-footer">
            <footer>
                <p>&copy; 2024 Sistema Eventos - PPI</p>
            </footer>
        </div>

    </div>
</body>
</html>
