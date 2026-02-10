<?php
namespace App\controller;

use Flight;
class ObjetController{
    private $objetService;
    private $categoryService;

    public function __construct($objetService, $categoryService)
    {
        $this->objetService = $objetService;
        $this->categoryService = $categoryService;
    }

    public function showFormCreate()
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }
        
        $categories = $this->categoryService->getAllCategories();
        Flight::render('ObjetForm', ['categories' => $categories]);
    }

    public function createObjet()
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $nom = Flight::request()->data->nom;
        $description = Flight::request()->data->description;
        $id_category = Flight::request()->data->id_category;
        $prix = Flight::request()->data->prix;
        $id_user = $_SESSION['user']['id_user'];

        $this->objetService->createObjet($nom, $description, $id_category, $id_user, $prix);
        Flight::redirect('/home');
    }

    public function showFormEdit($id)
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $objet = $this->objetService->getObjetById($id);
        $categories = $this->categoryService->getAllCategories();
        
        // Vérifier que l'objet appartient à l'utilisateur
        if ($objet['id_user'] != $_SESSION['user']['id_user']) {
            Flight::redirect('/home');
            return;
        }

        Flight::render('ObjetForm', ['objet' => $objet, 'categories' => $categories]);
    }

    public function updateObjet($id)
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $objet = $this->objetService->getObjetById($id);
        
        // Vérifier que l'objet appartient à l'utilisateur
        if ($objet['id_user'] != $_SESSION['user']['id_user']) {
            Flight::redirect('/home');
            return;
        }

        $nom = Flight::request()->data->nom;
        $description = Flight::request()->data->description;
        $id_category = Flight::request()->data->id_category;
        $prix = Flight::request()->data->prix;

        $this->objetService->updateObjet($id, $nom, $description, $id_category, $prix);
        Flight::redirect('/home');
    }

    public function deleteObjet($id)
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $objet = $this->objetService->getObjetById($id);
        
        // Vérifier que l'objet appartient à l'utilisateur
        if ($objet['id_user'] != $_SESSION['user']['id_user']) {
            Flight::redirect('/home');
            return;
        }

        $this->objetService->deleteObjet($id);
        Flight::redirect('/home');
    }
}
