<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|string',
            'expiration_date' => 'nullable|date',
            'ingredients' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Product price must be a number.',
            'price.min' => 'Product price cannot be negative.',
            'stock.required' => 'Stock quantity is required.',
            'stock.integer' => 'Stock must be an integer.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
