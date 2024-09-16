<?php
session_start();

require_once '../config/database.php';
require_once '../app/models/LoginModel.php';

class LoginController {
    private $loginModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->loginModel = new LoginModel($db);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->loginModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("Location: /eventos/app/views/admin/dashboard.php");
                } else {
                    header("Location: /eventos/app/views/user/dashboard.php");
                }
                exit;
            } else {
                echo "Email ou senha incorretos.";
            }
        }
    }
}

