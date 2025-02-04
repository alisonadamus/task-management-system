<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$taskController = new Alison\TaskManagementSystem\Controller\TaskController();
$task = null;
$users = $taskController->getUsersNames();

if (isset($_GET['id'])) {
    $task = $taskController->getTaskById((int)$_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        if ($task) {
            $taskController->deleteTask($task->getId());
            header('Location: tasks.php');
            exit;
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'] ?? null;
        $status = $_POST['status'];
        $assignedToId = $_POST['assigned_to'] !== '' ? (int) $_POST['assigned_to'] : null;

        if ($task) {
            $taskController->updateTask($task->getId(), $title, $description, $status, $_SESSION['user_id'], $assignedToId);
        } else {
            $taskController->saveTask($title, $description, $status, $_SESSION['user_id'], $assignedToId);
        }

        header('Location: tasks.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма завдання</title>
</head>
<body>
<h1><?= $task ? 'Редагувати' : 'Створити' ?> завдання</h1>
<form method="POST">
    <label for="title">Заголовок:</label>
    <input type="text" id="title" name="title" value="<?= $task ? htmlspecialchars($task->getTitle()) : '' ?>" required>

    <label for="description">Опис:</label>
    <textarea id="description"
              name="description"><?= $task ? htmlspecialchars($task->getDescription() ?? '') : '' ?></textarea>

    <label for="status">Статус:</label>
    <select name="status" id="status">
        <option value="В очікуванні" <?= $task && $task->getStatus() === 'В очікуванні' ? 'selected' : '' ?>>В
            очікуванні
        </option>
        <option value="В процесі" <?= $task && $task->getStatus() === 'В процесі' ? 'selected' : '' ?>>В процесі
        </option>
        <option value="Завершено" <?= $task && $task->getStatus() === 'Завершено' ? 'selected' : '' ?>>Завершено
        </option>
    </select>

    <label for="assigned_to">Виконавець:</label>
    <select name="assigned_to" id="assigned_to">
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>" <?= $task && $task->getAssignedToId() === $user['id'] ? 'selected' : '' ?>>
                <?= $user['username'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= $task ? 'Оновити' : 'Створити' ?></button>

    <?php if ($task): ?>
        <button type="submit" name="delete" value="1"
                onclick="return confirm('Ви впевнені, що хочете видалити це завдання?')">Видалити
        </button>
    <?php endif; ?>
</form>

<p><a href="tasks.php">Назад до завдань</a></p>
</body>
</html>