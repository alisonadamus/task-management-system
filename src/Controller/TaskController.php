<?php

namespace Alison\TaskManagementSystem\Controller;

use Alison\TaskManagementSystem\Model\Task;
use Alison\TaskManagementSystem\Service\Database;
use Alison\TaskManagementSystem\Service\TaskManager;
use Alison\TaskManagementSystem\Service\UserManager;

class TaskController
{
    private TaskManager $taskManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->taskManager = new TaskManager(Database::getConnection());
        $this->userManager = new UserManager(Database::getConnection());
    }
    public function getAllTasksByUser(int $userId): array
    {
        return $this->taskManager->getAllTasksByUser($userId);
    }

    public function getTaskById(int $taskId): Task
    {
        return $this->taskManager->getTaskById($taskId);
    }

    public function saveTask(
        string $title,
        ?string $description,
        string $status,
        int $creatorId,
        ?int $assignedToId
    ): void {
        $this->taskManager->saveTask(new Task((int)null, $title, $description, $status, $creatorId, $assignedToId,
            null, null));
    }

    public function updateTask(
        int $taskId,
        string $title,
        ?string $description,
        string $status,
        int $creatorId,
        ?int $assignedToId
    ): void {
        $this->taskManager->updateTask(new Task($taskId, $title, $description, $status, $creatorId, $assignedToId,
            null, null));
    }

    public function deleteTask(int $taskId): void {
        $this->taskManager->deleteTaskById($taskId);
    }

    public function getUsersNames(): array {
        return $this->userManager->getUsersNames();
    }
}