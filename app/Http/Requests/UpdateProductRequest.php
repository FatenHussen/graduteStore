<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'image' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'ingredients' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The product name must be a valid string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'description.string' => 'The description must be a valid string.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'stock.integer' => 'The stock quantity must be a valid integer.',
            'stock.min' => 'The stock quantity cannot be less than 0.',
            'image.string' => 'The image URL must be a valid string.',
            'expiration_date.date' => 'The expiration date must be a valid date.',
            'ingredients.string' => 'The ingredients field must be a valid string.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
