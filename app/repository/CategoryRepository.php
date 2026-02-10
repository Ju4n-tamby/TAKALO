<?php

namespace App\repository;

class CategoryRepository
{
    private $pdo;
   

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllCategories()
    {
        $stmt = $this->pdo->query('SELECT * FROM category');
        return $stmt->fetchAll();
    }
    public function findCategoryById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id_category = :id_category');
        $stmt->execute(['id_category' => $id]);
        return $stmt->fetch();
    }
    public function createCategory($libelle)
    {
        // 1. Vérifier si la catégorie existe déjà
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE libelle = :libelle');
        $stmt->execute(['libelle' => $libelle]);

        if ($stmt->fetch()) {
            return false; // catégorie déjà existante
        }

        // 2. Créer la nouvelle catégorie
        $stmt = $this->pdo->prepare('INSERT INTO category (libelle) VALUES (:libelle)');
        return $stmt->execute([
            'libelle' => $libelle
        ]);
    }
    public function deleteCategory($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM category WHERE id_category = :id_category');
        return $stmt->execute(['id_category' => $id]);
    }
    public function updateCategory($id, $libelle)
    {
        $stmt = $this->pdo->prepare('UPDATE category SET libelle = :libelle WHERE id_category = :id_category');
        return $stmt->execute([
            'libelle' => $libelle,
            'id_category' => $id
        ]);
    }
    
}
   