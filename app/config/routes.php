<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);



use flight\Engine;
use flight\net\Router;
use App\services\UserService;
use App\controller\UserController;
use App\repository\UserRepository;
use App\controller\AdminController;
use App\repository\CategoryRepository;
use App\services\CategoryService;




/**
 * @var Router $router
 * @var Engine $app
 */

// Get PDO instance from Flight's database service
$pdo = Flight::db();

// Initialize dependencies
$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);
$categoryRepository = new CategoryRepository($pdo);
$categoryService = new CategoryService($categoryRepository);

$userController = new UserController($userService);
$adminController = new AdminController($userService, $categoryService);



// Define routes
Flight::route('GET /', [$userController, 'showLoginForm']);
Flight::route('POST /log', [$userController, 'login']);     
Flight::route('GET /admin', [$adminController, 'showAdminDashboard']);       