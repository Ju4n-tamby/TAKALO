<?php
namespace App\controller;

use Flight;
class AdminController
{
    private $userService;
    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function showAdminDashboard()
    {
        // Vérifier si l'utilisateur est connecté et est un admin
        if (isset($_SESSION['user']) && $this->userService->verifyIfUserIsAdminById($_SESSION['user']['id_user'])) {
            // Afficher le tableau de bord admin
            Flight::render('adminSpace');
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
            Flight::render('home');
        }
    }


}