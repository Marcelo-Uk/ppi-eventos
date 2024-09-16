<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <img src="/eventos/assets/logo.png" alt="Logo" width="100">
        <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
    </header>

    <h1>Bem-vindo, Admin!</h1>

    <footer>
        <p>&copy; 2024 Sistema Eventos - PPI || Devs: Marcelo-Uk | Matheus Marinho | Frederico Andre</p>
    </footer>        
</body>
</html>
