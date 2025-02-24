<?php
namespace App\Repositories;

use App\Models\UserTest;
use App\Models\User;
use PDO;

class UserTestRepository
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getOrCreateUser($userName)
    {

        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE name = ?");
        $stmt->execute([$userName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['id'];
        } else {
         
            $stmt = $this->pdo->prepare("INSERT INTO users (name, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->execute([$userName]);
            return $this->pdo->lastInsertId(); 
        }
    }

    public function saveUserTest($userId, $testId, $score)
    {
       
        $stmt = $this->pdo->prepare("INSERT INTO user_tests (user_id, test_id, score, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$userId, $testId, $score]);
        return $this->pdo->lastInsertId();
    }
}
