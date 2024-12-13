<?php

namespace Alison\TaskManagementSystem\Controller;

use Alison\TaskManagementSystem\Model\User;
use Alison\TaskManagementSystem\Service\Database;
use Alison\TaskManagementSystem\Service\UserManager;

class UserController
{
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager(Database::getConnection());
    }

    public function register(string $username, string $email, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userManager->saveUser(new User((int)null, $username, $email, $hashedPassword));
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userManager->getUserByEmail($email);
        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            return true;
        }
        return false;
    }

    public function getUserById(int $userId): User
    {
        return $this->userManager->getUserById($userId);
    }
}