<?php

namespace App\repository;

class ObjetRepository
{
    private $pdo;
   

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function findAllObjets()
    {
        $stmt = $this->pdo->query('SELECT * FROM Objet');
        return $stmt->fetchAll();
    }
    public function findObjetById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Objet WHERE id_objet
    = :id_objet');
        $stmt->execute(['id_objet' => $id]);
        return $stmt->fetch();
    }
    public function createObjet($nom, $description, $id_category, $id_user, $prix = 0)
    {
        $stmt = $this->pdo->prepare('INSERT INTO Objet (nom, description,
        id_category, id_user, prix) VALUES (:nom, :description, :id_category, :id_user, :prix)');
        return $stmt->execute([
            'nom' => $nom,
            'description' => $description,
            'id_category' => $id_category,
            'id_user' => $id_user,
            'prix' => $prix
        ]);
    
    }
    public function deleteObjet($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM Objet WHERE id_objet = :id_objet');
        return $stmt->execute(['id_objet' => $id]);
    }
    public function updateObjet($id, $nom, $description, $id_category, $prix)
    {
        $stmt = $this->pdo->prepare('UPDATE Objet SET nom = :nom,
        description = :description, id_category = :id_category, prix = :prix WHERE id_objet = :id_objet');
        return $stmt->execute([
            'nom' => $nom,
            'description' => $description,
            'id_category' => $id_category,
            'prix' => $prix,
            'id_objet' => $id
        ]);

    }

    public function findObjetsByUserId($id_user)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Objet WHERE id_user = :id_user');
        $stmt->execute(['id_user' => $id_user]);
        return $stmt->fetchAll();
    }

    public function addImageToObjet($id_objet, $image_path)
    {
        $stmt = $this->pdo->prepare('UPDATE Objet SET image_path = :image_path WHERE id_objet = :id_objet');
        return $stmt->execute([
            'image_path' => $image_path,
            'id_objet' => $id_objet
        ]);
    }
        

}