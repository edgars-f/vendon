<?php
namespace App\Repositories;

use App\Models\Test;
use PDO;

class TestRepository
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getAllTests()
    {
        $stmt = $this->pdo->query("SELECT * FROM tests");
        $tests = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tests[] = new Test($row['id'], $row['title'], $row['created_at'], $row['updated_at']);
        }

        return $tests;
    }

    public function getTestById($testId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tests WHERE id = ?");
        $stmt->execute([$testId]);
        $test = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($test) {
            $questions = $this->getQuestionsByTestId($testId);
            return [
                'id' => $test['id'],
                'title' => $test['title'],
                'created_at' => $test['created_at'],
                'updated_at' => $test['updated_at'],
                'questions' => $questions,
            ];
        }

        return null; // Test not found
    }

    private function getQuestionsByTestId($testId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE test_id = ?");
        $stmt->execute([$testId]);
        $questions = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $answers = $this->getAnswersByQuestionId($row['id']);
            $questions[] = [
                'id' => $row['id'],
                'text' => $row['text'],
                'answers' => $answers,
            ];
        }

        return $questions;
    }

    private function getAnswersByQuestionId($questionId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE question_id = ?");
        $stmt->execute([$questionId]);
        $answers = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $answers[] = [
                'id' => $row['id'],
                'text' => $row['text'],
                'is_correct' => (bool)$row['is_correct'],
            ];
        }

        return $answers;
    }

    public function getReports()
{
    $stmt = $this->pdo->prepare("
        SELECT u.name AS user_name, t.title AS test_title, ut.score, ut.created_at
        FROM user_tests ut
        JOIN users u ON ut.user_id = u.id
        JOIN tests t ON ut.test_id = t.id
    ");
    $stmt->execute();
    $reports = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $reports[] = [
            'user_name' => $row['user_name'],
            'test_title' => $row['test_title'],
            'score' => $row['score'],
            'created_at' => $row['created_at'],
        ];
    }

    return $reports;
}

}
