<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/eventos/public/css/style.css"> <!-- Linkando o seu arquivo CSS principal -->
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="header-logo">
                <img class="img-logo" src="/eventos/assets/logo.png" alt="Logo">
            </div>
            <form method="POST" action="login.php">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Digite seu email" required>

                <label for="password">Senha</label>
                <input type="password" name="password" placeholder="Digite sua senha" required>

                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
