<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/vlucas/phpdotenv/src/Dotenv.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection
$pdo = new PDO(
    "mysql:host=" . $_ENV['MYSQL_HOST'] . ";dbname=" . $_ENV['MYSQL_DATABASE'],
    $_ENV['MYSQL_USER'],
    $_ENV['MYSQL_PASSWORD'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
