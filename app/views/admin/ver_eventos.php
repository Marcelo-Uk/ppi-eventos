<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

// Consultar eventos no banco de dados
$query = "SELECT * FROM eventos";
$result = pg_query($conn, $query);
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
    <header>
        <img src="/eventos/assets/logo.png" alt="Logo" width="100">
        <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
    </header>

    <div class="container">
        <h1>Eventos Cadastrados</h1>
        <table border="1" cellpadding="10">
            <tr>
                <th>Nome do Evento</th>
                <th>Data</th>
                <th>Local</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = pg_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['data']); ?></td>
                    <td><?php echo htmlspecialchars($row['local']); ?></td>
                    <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                    <td>
                        <!-- Botão de editar -->
                        <a href="/eventos/app/views/admin/editar_evento.php?id=<?php echo $row['id']; ?>">
                            <button>Editar</button>
                        </a>

                        <!-- Botão de deletar -->
                        <form method="POST" action="/eventos/app/controllers/DeleteEventController.php" onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit">Excluir</button>
                        </form>


                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema Eventos - PPI</p>
    </footer>
</body>
</html>
