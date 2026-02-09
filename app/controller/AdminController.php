<?php
namespace App\controller;

use Flight;
use App\services\CategoryService;
use App\services\UserService;
class AdminController
{
    private $userService;
    private $categoryService;
    public function __construct($userService, $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function showAdminDashboard()
    {
        // Vérifier si l'utilisateur est connecté et est un admin
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            // Afficher le tableau de bord admin
            $categories = $this->categoryService->getAllCategories();
            Flight::render('adminSpace', ['categories' => $categories]);
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
            Flight::render('home');
        }
    }


}