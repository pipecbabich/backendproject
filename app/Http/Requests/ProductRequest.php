<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product.name' => ['required', 'string', 'max:100'],
            'product.price' => ['required', 'numeric', 'min:0'],
            'product.description' => ['nullable', 'string'],
            'product.status' => ['nullable', 'bool'],
            'product.category_id' => ['required', 'int', 'exists:categories,id']
        ];
    }
}
