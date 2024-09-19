<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require_once '../../../config/database.php'; // Caminho correto para o arquivo de banco de dados

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Consultar o usuário com PDO
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Buscar o usuário
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $userId = $_POST['id'];
    
    // Atualizar a senha somente se o campo for preenchido
    $password = $_POST['password'];
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE users SET email = :email, password = :password, role = :role WHERE id = :id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':password', $hashed_password);
    } else {
        // Atualizar sem modificar a senha
        $updateQuery = "UPDATE users SET email = :email, role = :role WHERE id = :id";
        $stmt = $conn->prepare($updateQuery);
    }
    
    // Vincular parâmetros
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
    // Executar a query
    if ($stmt->execute()) {
        header("Location: /eventos/app/views/admin/ver_usuarios.php");
        exit;
    } else {
        echo "Erro ao atualizar o usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
                <h1>Editar Usuário</h1>

                <form action="editar_usuario.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

                    <label for="email">Email do Usuário:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                    <label for="password">Nova Senha (deixe em branco se não quiser alterar):</label>
                    <input type="password" name="password">

                    <label for="role">Função:</label>
                    <select name="role" required>
                        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>Usuário</option>
                    </select>

                    <button type="submit">Salvar Alterações</button>
                </form>
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
