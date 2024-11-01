<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        ];
    }

    
}
