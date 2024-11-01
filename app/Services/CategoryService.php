<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories($search = null)
    {
        // Check if a search term is provided; if so, filter categories by name
        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->get();
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
    }
}
