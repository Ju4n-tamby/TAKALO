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
    public function login()
    {
        $username = Flight::request()->data->username;
        $password = Flight::request()->data->password;

        $user = $this->userService->authenticate($username, $password);
        if ($user) {
            // Authentification réussie
            
            $_SESSION['user'] = $user;
            Flight::render('home' , ['user' => $user]);
        } else {
            // Échec de l'authentification
            $errorMessage = "Nom d'utilisateur ou mot de passe incorrect.";
            Flight::render('login', ['error' => $errorMessage]);
        }
    }


}