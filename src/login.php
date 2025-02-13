<?php
require '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if (password_verify($password, $ADMIN_PASSWORD_HASH)) {
        $_SESSION['auth'] = true;
        header('Location: stats.php');
        exit;
    }
    $error = "Неверный пароль!";
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
        <input type="password" name="password" placeholder="Пароль" required>
        <button>Войти</button>
    </form>
</body>
</html>