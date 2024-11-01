<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;

class ProductService
{
    public function getAllProducts($categoryId = null, $categoryName = null)
    {
        // Start a query for products
        $query = Product::query()->with('category');

        // Filter by category_id if provided
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by category_name if provided
        if ($categoryName) {
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
        }

        return $query->get();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
    }
}
