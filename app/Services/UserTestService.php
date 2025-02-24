<?php
namespace App\Services;

use App\Repositories\UserTestRepository;

class UserTestService
{
    private $userTestRepository;

    public function __construct()
    {
        $this->userTestRepository = new UserTestRepository();
    }

    public function saveUserTestResults($userName, $testId, $score)
    {
        // First, get or create the user
        $userId = $this->userTestRepository->getOrCreateUser($userName);

        // Save the user test
        $userTestId = $this->userTestRepository->saveUserTest($userId, $testId, $score);

        // You can also save user answers here if needed, depending on your frontend implementation

        return [
            'message' => 'Results saved successfully',
            'userTestId' => $userTestId,
        ];
    }
}
