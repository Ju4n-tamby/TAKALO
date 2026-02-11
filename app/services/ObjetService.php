<?php
namespace App\services;
use App\repository\ObjetRepository;
class ObjetService
{
    private $objetRepository;
    private $imageService;

    public function __construct($objetRepository, $imageService = null)
    {
        $this->objetRepository = $objetRepository;
        $this->imageService = $imageService;
    }

    public function getAllObjets()
    {
        return $this->objetRepository->findAllObjets();
    }
    public function getObjetById($id)
    {
        return $this->objetRepository->findObjetById($id);
    }
    public function createObjet($nom, $description, $id_category, $id_user, $prix = 0)
    {
        return $this->objetRepository->createObjet($nom, $description, $id_category, $id_user, $prix);
    }
    public function deleteObjet($id)
    {
        return $this->objetRepository->deleteObjet($id);
    }
    public function updateObjet($id, $nom, $description, $id_category, $prix)
    {
        return $this->objetRepository->updateObjet($id, $nom, $description, $id_category, $prix);
    }
    public function getObjetsByUserId($id_user)
    {
        $objets = $this->objetRepository->findObjetsByUserId($id_user);
        
        // Load images for each object if imageService is available
        if ($this->imageService && is_array($objets)) {
            foreach ($objets as &$objet) {
                $objet['images'] = $this->imageService->getImagesByObjet($objet['id_objet']);
            }
        }
        
        return $objets;
    }
    public function addImageToObjet($id_objet, $image_path)
    {
        return $this->objetRepository->addImageToObjet($id_objet, $image_path);
    }


}