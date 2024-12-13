<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $authController = new Alison\TaskManagementSystem\Controller\UserController();
    if ($authController->login($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Невірний email або пароль.";
    }
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизація</title>
</head>
<body>
<h1>Авторизація</h1>
<?php if (isset($error)) {
    echo "<p>$error</p>";
} ?>
<form method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Вхід</button>
</form>
<p>Ще не маєте акаунту? <a href="register.php">Реєстрація</a></p>
</body>
</html>