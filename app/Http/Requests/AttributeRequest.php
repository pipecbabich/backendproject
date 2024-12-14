<?php

namespace App\Http\Requests;

use App\Enums\AttributeName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'attribute.name' => ['nullable', 'string', Rule::enum(AttributeName::class)],
            'attribute.value' => ['required', 'string', 'max:200'],
            'attribute.product_id' => ['nullable', 'int', 'exists:products,id'],
        ];
    }
}
