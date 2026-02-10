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
    public function showFormCategory()
    {
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            Flight::render('FormCategory');
        } else {
            Flight::render('home');
        }
    }
    public function deleteCategory($id)
    {
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            $this->categoryService->deleteCategory($id);
            Flight::redirect('/admin');
        } else {
            Flight::render('home');
        }
    }
    public function createCategory()
    {
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            $libelle = Flight::request()->data->libelle;
            $this->categoryService->createCategoryIfNotExists($libelle);
            Flight::redirect('/admin');
        } else {
            Flight::render('home');
        }
    }
    public function showFormEditCategory($id)
    {
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            $category = $this->categoryService->getCategoryById($id);
            Flight::render('FormCategory', ['category' => $category]);
        } else {
            Flight::render('home');
        }
    }
    public function updateCategory($id)
    {
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            $libelle = Flight::request()->data->libelle;
            $this->categoryService->updateCategory($id, $libelle);
            Flight::redirect('/admin');
        } else {
            Flight::render('home');
        }
    }


}