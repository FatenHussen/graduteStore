<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        
        // Apply admin middleware to CRUD actions only
        $this->middleware('admin');
    }

    // GET /api/categories (accessible to all users)
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return CategoryResource::collection($categories);
    }

    // POST /api/categories (admin only)
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        return new CategoryResource($category);
    }

    // PUT /api/categories/{category} (admin only)
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->updateCategory($category, $request->validated());
        return new CategoryResource($category);
    }

    // DELETE /api/categories/{category} (admin only)
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
