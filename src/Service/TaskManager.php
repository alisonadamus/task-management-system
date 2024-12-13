<?php

namespace Alison\TaskManagementSystem\Service;

use Alison\TaskManagementSystem\Model\Task;
use DateMalformedStringException;
use DateTime;
use PDO;

readonly class TaskManager
{
    public function __construct(private PDO $db)
    {

    }

    public function getAllTasksByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM tasks WHERE creator_id = :user_id OR assigned_to_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $tasks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            try {
                $tasks[] = new Task(
                    $row['id'],
                    $row['title'],
                    $row['description'],
                    $row['status'],
                    $row['creator_id'],
                    $row['assigned_to_id'],
                    new DateTime($row['created_at']),
                    new DateTime($row['updated_at'])
                );
            } catch (DateMalformedStringException $e) {
                echo $e->getMessage();
                exit;
            }
        }

        return $tasks;
    }

    public function getTaskById(int $taskId): ?Task
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = :task_id");
        $stmt->execute(['task_id' => $taskId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        try {
            return new Task(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['status'],
                $row['creator_id'],
                $row['assigned_to_id'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at'])
            );
        } catch (DateMalformedStringException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function saveTask(Task $task): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO tasks (title, description, status, creator_id, assigned_to_id)
            VALUES (:title, :description, :status, :creator_id, :assigned_to_id)
        ");
        $stmt->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'creator_id' => $task->getCreatorId(),
            'assigned_to_id' => $task->getAssignedToId()
        ]);
    }

    public function updateTask(Task $task): void
    {
        $stmt = $this->db->prepare("
            UPDATE tasks SET title = :title, description = :description, status = :status, 
                             assigned_to_id = :assigned_to_id, updated_at = NOW() WHERE id = :task_id
        ");
        $stmt->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'assigned_to_id' => $task->getAssignedToId(),
            'task_id' => $task->getId()
        ]);
    }

    public function deleteTaskById(int $taskId): void
    {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :task_id");
        $stmt->execute(['task_id' => $taskId]);
    }
}