<?php

namespace App\repository;

class UserRepository
{
    private $pdo;
    public function createUser($nom, $password, $id_type_user)
    {
        // 1. Vérifier si l'utilisateur existe déjà
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE nom = :nom');
        $stmt->execute(['nom' => $nom]);

        if ($stmt->fetch()) {
            return false; // utilisateur déjà existant
        }

        // 2. Créer le nouvel utilisateur
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO user (nom, password, id_type_user) VALUES (:nom, :password, :id_type_user)');
        return $stmt->execute([
            'nom' => $nom,
            'password' => $hashedPassword,
            'id_type_user' => $id_type_user
        ]);
    }

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllUSers()
    {
        $stmt = $this->pdo->query('SELECT * FROM user');
        return $stmt->fetchAll();
    }
    public function findUserById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function findAdminUser()
    {
        $stmt = $this->pdo->query('SELECT * FROM user WHERE id_type_user = 1 LIMIT 1');
        return $stmt->fetch();
    }
    public function verifyIfUserExists($nom, $password)
    {
        // 1. Chercher l'utilisateur par son nom
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE username = :username');
        $stmt->execute(['username' => $nom]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // 2. Vérifier le mot de passe
        if ($user && isset($user['password']) && $password == $user['password']) {
            return $user; // utilisateur trouvé et mot de passe correct
        }

        return false; // utilisateur inexistant ou mauvais mot de passe
    }
    public function verifyIfUserIsAdminById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id_user = :id_user AND id_type_user = 1');
        $stmt->execute(['id_user' => $id]);
        return $stmt->fetch();
    }
  
    





}