<?php
namespace App\services;

use App\repository\CategoryRepository;

class CategoryService
{
    
    private $categoryRepository;

    public function __construct($categoryRepository)
    {
        
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->findAllCategories();
    }
    public function getCategoryById($id)
    {
        return $this->categoryRepository->findCategoryById($id);
    }
    public function createCategory($libelle)
    {
        return $this->categoryRepository->createCategory($libelle);
    }
    public function deleteCategory($id)
    {
        return $this->categoryRepository->deleteCategory($id);
    }






}