<?php

namespace App\repository;

class ImageRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addImage($id_objet, $url)
    {
        $stmt = $this->pdo->prepare('INSERT INTO image (url, id_objet) VALUES (:url, :id_objet)');
        return $stmt->execute([
            'url' => $url,
            'id_objet' => $id_objet
        ]);
    }

    public function getImagesByObjet($id_objet)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM image WHERE id_objet = :id_objet');
        $stmt->execute(['id_objet' => $id_objet]);
        return $stmt->fetchAll();
    }

    public function deleteImage($id_image)
    {
        $stmt = $this->pdo->prepare('DELETE FROM image WHERE id_image = :id_image');
        return $stmt->execute(['id_image' => $id_image]);
    }

    public function getImageById($id_image)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM image WHERE id_image = :id_image');
        $stmt->execute(['id_image' => $id_image]);
        return $stmt->fetch();
    }
}
