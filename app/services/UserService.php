<?php
namespace App\services;
class UserService
{
    private $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAllUSers();
    }
    public function getUserById($id)
    {
        return $this->userRepository->findUserById($id);
    }
    public function getAdminUser()
    {
        return $this->userRepository->findAdminUser();
    }
    public function authenticate($username, $password)
    {
        return $this->userRepository->verifyIfUserExists($username, $password);
    }
    public function verifyIfUserIsAdminById($id)
    {
        return $this->userRepository->verifyIfUserIsAdminById($id);
    }

   
}
 

  

    

