<?php
namespace App\Models;

class UserTest
{
    public $id;
    public $user_id;
    public $test_id;
    public $score;
    public $created_at;
    public $updated_at;

    public function __construct($id, $user_id, $test_id, $score, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->test_id = $test_id;
        $this->score = $score;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
