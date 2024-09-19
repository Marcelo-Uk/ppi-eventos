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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $created_at = date('Y-m-d H:i:s'); // Gerando data de criação atual

    if (!empty($email) && !empty($password) && !empty($role)) {
        // Criptografando a senha
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Usando a conexão do arquivo database.php com PDO
        $query = "INSERT INTO users (email, password, role, created_at) VALUES (:email, :password, :role, :created_at)";
        $stmt = $conn->prepare($query);
        
        // Vincular parâmetros
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':created_at', $created_at);
        
        // Executar a query e verificar se funcionou
        if ($stmt->execute()) {
            $message = "Usuário cadastrado com sucesso!";
            // Limpar campos após inserção
            $_POST = array();
        } else {
            $message = "Erro ao cadastrar usuário.";
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
    <title>Cadastrar Usuário</title>
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
                <h1>Preencha os Dados do Usuário</h1>

                <form method="POST" action="">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email do Usuário" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

                    <label for="password">Senha</label>
                    <input type="password" name="password" placeholder="Senha" required>

                    <label for="role">Função</label>
                    <select name="role" required>
                        <option value="">Selecione a função</option>
                        <option value="admin" <?php echo isset($_POST['role']) && $_POST['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo isset($_POST['role']) && $_POST['role'] === 'user' ? 'selected' : ''; ?>>Usuário</option>
                    </select>

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
