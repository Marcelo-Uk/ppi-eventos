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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }
        header img {
            vertical-align: middle;
        }
        header a {
            float: right;
            margin-right: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .container button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <img src="/eventos/assets/logo.png" alt="Logo" width="100">
        <a href="/eventos/app/controllers/LogoutController.php">Sair</a>
    </header>

    <div class="container">
        <h1>Bem-vindo, Admin!</h1>

        <!-- Botões para funcionalidades -->
        <button onclick="window.location.href='/eventos/app/views/admin/ver_eventos.php'">Ver Eventos Cadastrados</button>
        <button onclick="window.location.href='/eventos/app/views/admin/ver_usuarios.php'">Ver Usuários Cadastrados</button>
        <button onclick="window.location.href='/eventos/app/views/admin/cadastrar_eventos.php'">Cadastrar Eventos</button>
        <button onclick="window.location.href='/eventos/app/views/admin/cadastrar_usuarios.php'">Cadastrar Usuários</button>
    </div>

    <footer>
        <p>&copy; 2024 Sistema Eventos - PPI || Devs: Marcelo-Uk | Matheus Marinho | Frederico Andre</p>
    </footer>        
</body>
</html>
