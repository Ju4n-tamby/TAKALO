<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);



use flight\Engine;
use flight\net\Router;
use App\services\UserService;
use App\controller\UserController;
use App\repository\UserRepository;




/**
 * @var Router $router
 * @var Engine $app
 */

// Get PDO instance from Flight's database service
$pdo = Flight::db();

// Initialize dependencies
$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

// Define routes
Flight::route('GET /', [$userController, 'showLoginForm']);