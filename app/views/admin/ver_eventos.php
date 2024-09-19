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

// Incluindo o arquivo de configuração do banco de dados
require_once '../../../config/database.php'; 

// Verifica se a conexão com o banco foi estabelecida
if (!$conn) {
    die("Erro de conexão com o banco de dados.");
}

// Consultar eventos no banco de dados com PDO
$query = "SELECT * FROM eventos";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Nenhum evento encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Eventos</title>
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
        <div class="container">
            <div class="container-title">
                <h1>Eventos Cadastrados</h1>
            </div>
            <div class="container-tabelas">
                <table border="1" cellpadding="10">
                    <tr>
                        <th>Nome do Evento</th>
                        <th>Data</th>
                        <th>Local</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($result as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['data']); ?></td>
                            <td><?php echo htmlspecialchars($row['local']); ?></td>
                            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                            <td>
                                <!-- Botão de editar -->
                                <a href="/eventos/app/views/admin/editar_evento.php?id=<?php echo $row['id']; ?>">
                                    <button class="button-header">Editar</button>
                                </a>

                                <!-- Botão de deletar -->
                                <form method="POST" action="/eventos/app/controllers/DeleteEventController.php" onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <button class="button-header" type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>

        <div class="container-footer">
            <footer>
                <p>&copy; 2024 Sistema Eventos - PPI</p>
            </footer>
        </div>
    </div>

</body>
</html>
