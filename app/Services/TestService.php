<?php
namespace App\Services;

use App\Repositories\TestRepository;

class TestService
{
    private $testRepository;

    public function __construct()
    {
        $this->testRepository = new TestRepository();
    }

    public function getAllTests()
    {
        return $this->testRepository->getAllTests();
    }
    
    public function getTestById($testId)
    {
        return $this->testRepository->getTestById($testId);
    }

    public function getReports()
    {
        return $this->testRepository->getReports();
    }
}
