<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
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

        // Apply admin middleware only to store, update, and destroy methods
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    // GET /api/categories - Retrieve all categories, with optional filtering by name (accessible to all users)
    public function index(Request $request)
    {
        // Check for a 'search' query parameter for filtering by name
        $search = $request->query('search');
        $categories = $this->categoryService->getAllCategories($search);
        return CategoryResource::collection($categories);
    }

    // GET /api/categories/{id} - Retrieve a single category by ID (accessible to all users)
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    // POST /api/categories - Create a new category (admin only)
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        return new CategoryResource($category);
    }

    // PUT /api/categories/{id} - Update a category (admin only)
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->updateCategory($category, $request->validated());
        return new CategoryResource($category);
    }

    // DELETE /api/categories/{id} - Delete a category (admin only)
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
