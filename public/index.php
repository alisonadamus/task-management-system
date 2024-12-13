<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$userController = new Alison\TaskManagementSystem\Controller\UserController();
$user = $userController->getUserById($user_id);

echo "<h1>Ласкаво просимо, " . htmlspecialchars($user->getName()) . "</h1>";
echo "<p><a href='tasks.php'>Переглянути завдання</a></p>";
echo "<p><a href='logout.php'>Вийти</a></p>";