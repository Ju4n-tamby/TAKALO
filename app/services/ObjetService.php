<?php
namespace App\services;
use App\repository\ObjetRepository;
class ObjetService
{
    private $objetRepository;

    public function __construct($objetRepository)
    {
        $this->objetRepository = $objetRepository;
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
        return $this->objetRepository->findObjetsByUserId($id_user);
    }



}