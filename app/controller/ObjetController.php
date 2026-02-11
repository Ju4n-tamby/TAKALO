<?php
namespace App\controller;

use Flight;
class ObjetController{
    private $objetService;
    private $categoryService;
    private $imageService;

    public function __construct($objetService, $categoryService, $imageService = null)
    {
        $this->objetService = $objetService;
        $this->categoryService = $categoryService;
        $this->imageService = $imageService;
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

        $id_objet = $this->objetService->createObjet($nom, $description, $id_category, $id_user, $prix);
        
        // Handle image uploads
        if ($this->imageService && isset($_FILES['images'])) {
            $this->handleImageUploads($id_objet, $_FILES['images']);
        }

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

        $images = [];
        if ($this->imageService) {
            $images = $this->imageService->getImagesByObjet($id);
        }

        Flight::render('ObjetForm', ['objet' => $objet, 'categories' => $categories, 'images' => $images]);
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
        
        // Handle image uploads
        if ($this->imageService && isset($_FILES['images']) && isset($_FILES['images']['tmp_name'][0]) && !empty($_FILES['images']['tmp_name'][0])) {
            $this->handleImageUploads($id, $_FILES['images']);
        }

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

        // Delete images
        if ($this->imageService) {
            $images = $this->imageService->getImagesByObjet($id);
            foreach ($images as $image) {
                $this->deleteImageFile($image['url']);
                $this->imageService->deleteImage($image['id_image']);
            }
        }

        $this->objetService->deleteObjet($id);
        Flight::redirect('/home');
    }

    public function deleteImage($id)
    {
        if (!isset($_SESSION['user']) || !$this->imageService) {
            Flight::redirect('/');
            return;
        }

        $image = $this->imageService->getImageById($id);
        if (!$image) {
            Flight::redirect('/home');
            return;
        }

        $objet = $this->objetService->getObjetById($image['id_objet']);
        
        // Vérifier que l'objet appartient à l'utilisateur
        if ($objet['id_user'] != $_SESSION['user']['id_user']) {
            Flight::redirect('/home');
            return;
        }

        $this->deleteImageFile($image['url']);
        $this->imageService->deleteImage($id);
        Flight::redirect('/objets/edit/' . $image['id_objet']);
    }

    private function handleImageUploads($id_objet, $files)
    {
        if (!isset($files['tmp_name']) || !is_array($files['tmp_name'])) {
            return;
        }

        $count = 0;
        foreach ($files['tmp_name'] as $index => $tmp_name) {
            if (empty($tmp_name)) {
                continue;
            }

            if ($count >= 5) {
                break;
            }

            $file = [
                'tmp_name' => $tmp_name,
                'name' => $files['name'][$index],
                'type' => $files['type'][$index],
                'size' => $files['size'][$index],
                'error' => $files['error'][$index]
            ];

            $uploadedPath = $this->imageService->uploadImage($file);
            if ($uploadedPath) {
                $this->imageService->addImage($id_objet, $uploadedPath);
                $count++;
            }
        }
    }

    private function deleteImageFile($url)
    {
        $filePath = __DIR__ . '/../../public' . $url;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    public function getAllOtherObjets()
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $id_user = $_SESSION['user']['id_user'];
        $objets = $this->objetService->getAllOtherObjets($id_user);
        
        // Get user's own objects for the exchange form
        $myObjets = $this->objetService->getObjetsByUserId($id_user);
        
        Flight::render('AutreObjets', ['objets' => $objets, 'myObjets' => $myObjets, 'user' => $_SESSION['user']]);
    }
}