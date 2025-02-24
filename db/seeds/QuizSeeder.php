<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory;

class QuizSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Factory::create();

        // Insert 10 random tests
        $tests = [];
        for ($i = 0; $i < 10; $i++) {
            $tests[] = [
                'title' => $faker->sentence(3),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->table('tests')->insert($tests)->save();

        // Retrieve test IDs
        $testIds = $this->fetchAll('SELECT id FROM tests');

        foreach ($testIds as $test) {
            $testId = $test['id'];
            $numQuestions = rand(5, 9);
            
            for ($j = 0; $j < $numQuestions; $j++) {
                $question = [
                    'test_id' => $testId,
                    'text' => $faker->sentence(10),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->table('questions')->insert($question)->save();

                // Retrieve last inserted question ID
                $questionId = $this->getAdapter()->getConnection()->lastInsertId();
                
                $numAnswers = rand(2, 8);
                $correctAnswerIndex = rand(0, $numAnswers - 1);
                $answers = [];
                
                for ($k = 0; $k < $numAnswers; $k++) {
                    $answers[] = [
                        'question_id' => $questionId,
                        'text' => $faker->sentence(6),
                        'is_correct' => ($k === $correctAnswerIndex),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
                $this->table('answers')->insert($answers)->save();
            }
        }
    }
}
