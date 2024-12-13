<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$taskController = new Alison\TaskManagementSystem\Controller\TaskController();
$userTasks = $taskController->getAllTasksByUser($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Завдання</title>
</head>
<body>
<h1>Ваші завдання</h1>
<p><a href="index.php">Головна</a></p>
<p><a href="task_form.php">Створити завдання</a></p>

<?php if (count($userTasks) > 0): ?>
    <ul>
        <?php foreach ($userTasks as $task): ?>
            <li>
                <a href="task_form.php?id=<?= $task->getId() ?>"><?= $task->getTitle() ?></a>
                - Статус: <?= $task->getStatus() ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>У вас ще немає завдань.</p>
<?php endif; ?>
</body>
</html>