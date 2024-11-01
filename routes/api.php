<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

// Get authenticated user information
Route::middleware('auth:jwt')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for categories
Route::middleware('auth:jwt')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']); // Accessible to all authenticated users
});

// Admin-only routes for categories (create, update, delete)
Route::middleware(['auth:jwt', 'admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
});

// Routes for products
Route::get('/products', [ProductController::class, 'index']); // Public access to list all products
Route::get('/products/{product}', [ProductController::class, 'show']); // Public access to show a single product

// Admin-only routes for products (create, update, delete)
Route::middleware(['auth:jwt', 'admin'])->group(function () {
    Route::apiResource('products', ProductController::class);
});
