<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductCommentRequest extends FormRequest
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
            'name' => auth()->check() ? '' : 'required|string|min:3|max:100',
            'email' => auth()->check() ? '' : 'required|email',
            'url' => 'nullable|url',
            'body' => 'required|string|min:3|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ];
    }
}
