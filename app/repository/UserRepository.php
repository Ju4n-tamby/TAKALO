<?php

namespace App\rephsitory;

class UserRepository
{
    private $pdo;
    public function createUser($nom, $password, $id_type_user)
    {
        // 1. Vérifier si l'utilisateur existe déjà
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE nom = :nom');
        $stmt->execute(['nom' => $nom]);

        if ($stmt->fetch()) {
            return false; // utilisateur déjà existant
        }

        // 2. Créer le nouvel utilisateur
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (nom, password, id_type_user) VALUES (:nom, :password, :id_type_user)');
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
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll();
    }
    public function findUserById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function findAdminUser()
    {
        $stmt = $this->pdo->query('SELECT * FROM users WHERE id_type_user = 1 LIMIT 1');
        return $stmt->fetch();
    }
    public function verifyIfUserExists($nom, $password)
    {
        // 1. Chercher l'utilisateur par son nom
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE nom = :nom');
        $stmt->execute(['nom' => $nom]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Vérifier le mot de passe
        if ($user && password_verify($password, $user['password'])) {
            return $user; // utilisateur trouvé et mot de passe correct
        }

        return false; // utilisateur inexistant ou mauvais mot de passe
    }
    





}