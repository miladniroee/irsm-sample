<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categories' => 'string|min:1|max:191|regex:/^(\d+(,\d+)*)?$/',
            'brands' => 'string|min:1|max:191|regex:/^(\d+(,\d+)*)?$/',
            'min_price' => 'numeric|lt:max_price|digits_between:3,10',
            'max_price' => 'numeric|gt:min_price|digits_between:3,10',
            'has_quantity' => 'boolean',
            'featured' => 'boolean',
        ];
    }
}
