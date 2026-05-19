<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'body' => ['required', 'string', 'min:100'],
            'slug' => ['required', 'string', 'unique:posts,slug', 'regex:/^[a-z0-9-]+$/'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.min'        => 'The post title must be at least 5 characters long.',
            'body.min'         => 'The post body must be at least 100 characters. Please write more content.',
            'slug.regex'       => 'The slug may only contain lowercase letters, numbers, and hyphens (e.g. my-post-title).',
            'slug.unique'      => 'This slug is already taken. Please choose a different one.',
            'category_ids.*'   => 'One or more selected categories do not exist.',
        ];
    }
}
