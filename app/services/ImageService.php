<?php

namespace App\services;

use App\repository\ImageRepository;

class ImageService
{
    private $imageRepository;

    public function __construct($imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function addImage($id_objet, $url)
    {
        return $this->imageRepository->addImage($id_objet, $url);
    }

    public function getImagesByObjet($id_objet)
    {
        return $this->imageRepository->getImagesByObjet($id_objet);
    }

    public function deleteImage($id_image)
    {
        return $this->imageRepository->deleteImage($id_image);
    }

    public function getImageById($id_image)
    {
        return $this->imageRepository->getImageById($id_image);
    }

    public function uploadImage($file)
    {
        if (!isset($file) || $file['error'] != 0) {
            return false;
        }

        // Créer le dossier uploads s'il n'existe pas
        $uploadsDir = __DIR__ . '/../../public/uploads';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }

        // Vérifier le type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Vérifier la taille (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return false;
        }

        // Générer un nom unique
        $filename = uniqid() . '_' . basename($file['name']);
        $filepath = $uploadsDir . '/' . $filename;

        // Déplacer le fichier
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/' . $filename;
        }

        return false;
    }
}
