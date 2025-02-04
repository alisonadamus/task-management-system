<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $authController = new Alison\TaskManagementSystem\Controller\UserController();
    $authController->register($username, $email, $password);
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
</head>
<body>
<h1>Реєстрація</h1>
<form method="POST">
    <label for="username">Ім’я користувача:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Зареєструватися</button>
</form>
<p>Маєте акаунт? <a href="login.php">Авторизація</a></p>
</body>
</html>