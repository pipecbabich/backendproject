<?php

namespace App\Services\Category;

use App\Models\Category;

class CategoryService
{
    private Category $category;

    public function update(array $data) 
    {
        $this->category->update($data);

        return $this->category;
    }

    public function create(array $data)
    {
        return Category::create($data);
    } 

    public function setCategory(Category $category)
    {
        $this->category = $category;
        
        return $this;
    }
}