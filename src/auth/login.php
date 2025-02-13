<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../db/config.php';
require '../../db/db_conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['auth'] = true;
            $location = "http://" . $_SERVER['HTTP_HOST'] . "/index.php";
            header("Location: $location");
            exit;
        }

        $error = "Неверные учетные данные!";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button>Войти</button>
    </form>
</body>
</html>