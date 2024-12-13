<?php

namespace Alison\TaskManagementSystem\Service;

use Alison\TaskManagementSystem\Model\User;
use PDO;

readonly class UserManager
{
    public function __construct(private PDO $db)
    {

    }

    public function getUsersNames(): array
    {
        $stmt = $this->db->prepare("SELECT id, username FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $userId): User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($row['id'], $row['username'], $row['email'], $row['password']);
    }
    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        return new User($row['id'], $row['username'], $row['email'], $row['password']);
    }

    public function saveUser(User $user): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ");
        $stmt->execute([
            'username' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }
}