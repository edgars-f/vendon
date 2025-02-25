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
        $userId = $this->userTestRepository->getOrCreateUser($userName);

        $userTestId = $this->userTestRepository->saveUserTest($userId, $testId, $score);

        return [
            'message' => 'Saved',
            'userTestId' => $userTestId,
        ];
    }
}
