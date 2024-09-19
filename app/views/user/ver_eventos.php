<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: /");
    exit;
}

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

// Consultar eventos em que o usuário está participando
$userId = $_SESSION['user_id'];
$queryParticipacao = "SELECT evento_id FROM participacoes WHERE user_id = :user_id";
$stmtParticipacao = $conn->prepare($queryParticipacao);
$stmtParticipacao->bindParam(':user_id', $userId);
$stmtParticipacao->execute();
$participacoes = $stmtParticipacao->fetchAll(PDO::FETCH_COLUMN);
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
                <button class="button-header" onclick="window.location.href='/eventos/app/views/user/dashboard.php'">Home</button>
                <button class="button-header" onclick="window.location.href='/eventos/app/controllers/LogoutController.php'">Sair</button>
            </div>
        </div>

        <div class="container">
            <div class="container-title">
                <h1>Eventos Disponíveis</h1>
            </div>
            <div class="container-tabelas">
                <table border="1" cellpadding="10">
                    <tr>
                        <th>Nome do Evento</th>
                        <th>Data</th>
                        <th>Local</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($result as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['data']); ?></td>
                            <td><?php echo htmlspecialchars($row['local']); ?></td>
                            <td>
                                <!-- Sempre mostrar o botão de Ver Detalhes -->
                                <a href="/eventos/app/views/user/detalhes_evento.php?id=<?php echo $row['id']; ?>">
                                    <button class="button-header">Ver Detalhes</button>
                                </a>

                                <!-- Mostrar Participar ou Cancelar Participação com base na participação do usuário -->
                                <?php if (in_array($row['id'], $participacoes)) { ?>
                                    <form method="POST" action="/eventos/app/controllers/CancelarParticipacaoController.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button class="button-cancelar" type="submit">Cancelar Participação</button>
                                    </form>
                                <?php } else { ?>
                                    <form method="POST" action="/eventos/app/controllers/ParticiparController.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button class="button-participar" type="submit">Participar</button>
                                    </form>
                                <?php } ?>
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
