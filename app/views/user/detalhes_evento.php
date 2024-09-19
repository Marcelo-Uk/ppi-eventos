<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; 

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $query = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Consultar se o usuário já está participando
$userId = $_SESSION['user_id'];
$queryParticipacao = "SELECT evento_id FROM participacoes WHERE user_id = :user_id AND evento_id = :evento_id";
$stmtParticipacao = $conn->prepare($queryParticipacao);
$stmtParticipacao->bindParam(':user_id', $userId);
$stmtParticipacao->bindParam(':evento_id', $eventId);
$stmtParticipacao->execute();
$isParticipating = $stmtParticipacao->rowCount() > 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
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
            <div class="container-details">
                <h1><?php echo htmlspecialchars($event['nome']); ?></h1>
                <p><?php echo htmlspecialchars($event['descricao']); ?></p>
    
                <!-- Botões de Voltar e Participar/Cancelar Participação -->
                <div style="display: flex; align-items: center;">
                    
                    <!-- Botão de Participar ou Cancelar Participação -->
                    <?php if ($isParticipating) { ?>
                        <form method="POST" action="/eventos/app/controllers/CancelarParticipacaoController.php" style="margin-left: 10px;">
                            <input type="hidden" name="id" value="<?php echo $eventId; ?>">
                            <button class="button-header" type="submit">Cancelar Participação</button>
                        </form>
                    <?php } else { ?>
                        <form method="POST" action="/eventos/app/controllers/ParticiparController.php" style="margin-left: 10px;">
                            <input type="hidden" name="id" value="<?php echo $eventId; ?>">
                            <button class="button-header" type="submit">Participar</button>
                        </form>
                    <?php } ?>
                    
                    <!-- Botão de Voltar -->
                    <button class="button-header" onclick="window.location.href='/eventos/app/views/user/ver_eventos.php'">Voltar</button>
                    
                </div>
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
