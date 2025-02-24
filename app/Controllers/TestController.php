<?php
namespace App\Controllers;

use App\Services\TestService;
use App\Services\UserTestService;

class TestController
{
    private $testService;
    private $userTestService;

    public function __construct()
    {
        $this->testService = new TestService();
        $this->userTestService = new UserTestService();
    }

    public function getAllTests()
    {
        header('Content-Type: application/json');
        echo json_encode($this->testService->getAllTests());
    }

    public function getTest($id)
    {
        header('Content-Type: application/json');
        $test = $this->testService->getTestById($id);
        
        if ($test) {
            echo json_encode($test);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Test not found']);
        }
    }

    public function submitResults()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['userName']) || empty($data['testId']) || !isset($data['score'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid input']);
                return;
            }

            $result = $this->userTestService->saveUserTestResults($data['userName'], $data['testId'], $data['score']);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Results saved successfully', 'data' => $result]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
        }
    }

    public function getReports()
    {
        header('Content-Type: application/json');
        $reports = $this->testService->getReports();
        
        if ($reports) {
            echo json_encode($reports);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No reports found']);
        }
    }
}
