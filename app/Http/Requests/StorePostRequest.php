<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'=> ['required', 'string', 'min:5', 'max:255'],
            'body'=> ['required', 'string', 'min:100'],
            'slug'=> ['nullable', 'string', 'regex:/^[a-z0-9-]+$/'], // REMOVED the unique rule
            'is_published'=> ['boolean'],
            'category_ids'=> ['array', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required for your post.',
            'title.min' => 'The title must be at least 5 characters long.',
            'body.min' => 'Your post content must be at least 100 characters.',
        ];
    }
}
