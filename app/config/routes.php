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
use App\services\ObjetService;
use App\repository\ObjetRepository;
use App\controller\ObjetController;
use App\repository\ImageRepository;
use App\services\ImageService;




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
$imageRepository = new ImageRepository($pdo);
$imageService = new ImageService($imageRepository);
$objetRepository = new ObjetRepository($pdo);
$objetService = new ObjetService($objetRepository, $imageService);



$userController = new UserController($userService, $objetService);
$adminController = new AdminController($userService, $categoryService);
$objetController = new ObjetController($objetService, $categoryService, $imageService);



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
Flight::route('GET /userList', [$adminController, 'getAllUsers']);

// Routes CRUD pour les objets
Flight::route('GET /objets/create', [$objetController, 'showFormCreate']);
Flight::route('POST /objets/create', [$objetController, 'createObjet']);
Flight::route('GET /objets/edit/@id', [$objetController, 'showFormEdit']);
Flight::route('POST /objets/edit/@id', [$objetController, 'updateObjet']);
Flight::route('GET /objets/delete/@id', [$objetController, 'deleteObjet']);
Flight::route('GET /objets/delete-image/@id', [$objetController, 'deleteImage']);