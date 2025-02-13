<?php
require 'db_conn.php';
require 'db_create.php';

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:admin, :password)");

$stmt->execute([
    ':admin' => 'admin',
    ':password' => $ADMIN_PASSWORD_HASH
]);
