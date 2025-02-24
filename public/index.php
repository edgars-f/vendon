<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fast fix for CORS policies.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use Bramus\Router\Router;
use App\Controllers\TestController;

$router = new Router();
$testController = new TestController();

$router->get('api/tests', [$testController, 'getAllTests']);
$router->get('api/tests/{id}', [$testController, 'getTest']);
$router->post('/api/user-tests', [$testController, 'submitResults']);
$router->get('/api/reports', [$testController, 'getReports']);

$router->run();
