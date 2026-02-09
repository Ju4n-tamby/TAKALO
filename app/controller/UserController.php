<?php
namespace App\controller;

use Flight;
class UserController
{
    private $userService;
    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        $adminUser = $this->userService->getAdminUser();
        if (!$adminUser) {
            // Si aucun utilisateur admin n'existe, afficher une erreur
            $errorMessage = "Aucun utilisateur admin trouvé. Veuillez créer un compte admin pour continuer.";
            Flight::render('login', ['error' => $errorMessage]);
        } else {
            // Sinon, afficher le formulaire de connexion avec les infos de l'admin
            Flight::render('login', ['adminUser' => $adminUser]);
        }
    }


}