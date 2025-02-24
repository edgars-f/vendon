<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuizTables extends AbstractMigration
{
    public function change(): void
    {
        // Users table
        $table = $this->table('users');
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addTimestamps()
              ->create();

        // Tests table
        $table = $this->table('tests');
        $table->addColumn('title', 'string', ['limit' => 255])
              ->addTimestamps()
              ->create();

        // Questions table
        $table = $this->table('questions');
        $table->addColumn('test_id', 'integer', ['signed' => false]) // Ensure test_id is unsigned
              ->addColumn('text', 'text')
              ->addTimestamps()
              ->addForeignKey('test_id', 'tests', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->create();

        // Answers table
        $table = $this->table('answers');
        $table->addColumn('question_id', 'integer', ['signed' => false]) // Ensure question_id is unsigned
              ->addColumn('text', 'text')
              ->addColumn('is_correct', 'boolean', ['default' => false])
              ->addTimestamps()
              ->addForeignKey('question_id', 'questions', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->create();

        // User tests table
        $table = $this->table('user_tests');
        $table->addColumn('user_id', 'integer', ['signed' => false]) // Ensure user_id is unsigned
              ->addColumn('test_id', 'integer', ['signed' => false]) // Ensure test_id is unsigned
              ->addColumn('score', 'integer', ['default' => 0])
              ->addTimestamps()
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->addForeignKey('test_id', 'tests', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->create();

        // User answers table
        $table = $this->table('user_answers');
        $table->addColumn('user_test_id', 'integer', ['signed' => false]) // Ensure user_test_id is unsigned
              ->addColumn('question_id', 'integer', ['signed' => false]) // Ensure question_id is unsigned
              ->addColumn('answer_id', 'integer', ['signed' => false]) // Ensure answer_id is unsigned
              ->addColumn('is_correct', 'boolean', ['default' => false])
              ->addTimestamps()
              ->addForeignKey('user_test_id', 'user_tests', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->addForeignKey('question_id', 'questions', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->addForeignKey('answer_id', 'answers', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->create();
    }
}
