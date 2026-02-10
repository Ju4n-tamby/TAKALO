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
Flight::route('GET /deconnect', [$userController, 'logout']);
Flight::route('GET /home', [$userController, 'showHome']);
Flight::route('GET /admin', [$adminController, 'showAdminDashboard']);  
Flight::route('GET /admin/categories/create', [$adminController, 'showFormCategory']);
Flight::route('GET /admin/categories/delete/@id', [$adminController, 'deleteCategory']); 
Flight::route('POST /admin/category/new', [$adminController, 'createCategory']);
Flight::route('GET /admin/categories/edit/@id', [$adminController, 'showFormEditCategory']);
Flight::route('POST /admin/categories/edit/@id', [$adminController, 'updateCategory']);