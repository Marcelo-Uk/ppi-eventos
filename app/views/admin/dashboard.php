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
        <div class="container-dashboard">
            <div class="container-dashboard-title">
                <h1>Bem-vindo, Admin!</h1>
            </div>  
            
            <div class="container-dashboard-botoes">
                <!-- Botões para funcionalidades -->
                <button class="button-header" onclick="window.location.href='/eventos/app/views/admin/cadastrar_eventos.php'">Cadastrar Eventos</button>
                <button class="button-header" onclick="window.location.href='/eventos/app/views/admin/ver_eventos.php'">Ver Eventos Cadastrados</button>
                <button class="button-header" onclick="window.location.href='/eventos/app/views/admin/cadastrar_usuarios.php'">Cadastrar Usuários</button>
                <button class="button-header" onclick="window.location.href='/eventos/app/views/admin/ver_usuarios.php'">Ver Usuários Cadastrados</button>
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
