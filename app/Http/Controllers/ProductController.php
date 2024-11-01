<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;

        // Apply admin middleware only to store, update, and destroy methods
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    // GET /api/products - Retrieve all products, with optional filtering by category name or id
    public function index(Request $request)
    {
        // Check for 'category_id' or 'category_name' query parameters for filtering
        $categoryId = $request->query('category_id');
        $categoryName = $request->query('category_name');

        $products = $this->productService->getAllProducts($categoryId, $categoryName);
        return ProductResource::collection($products);
    }

    // GET /api/products/{id} - Retrieve a single product by ID
    public function show($id)
    {
        // Find the product by ID or return a custom error response
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return new ProductResource($product);
    }

    // POST /api/products - Create a new product (admin only)
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());
        return new ProductResource($product);
    }

    // PUT /api/products/{id} - Update a product (admin only)
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product = $this->productService->updateProduct($product, $request->validated());
        return new ProductResource($product);
    }

    // DELETE /api/products/{id} - Delete a product (admin only)
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $this->productService->deleteProduct($product);
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
