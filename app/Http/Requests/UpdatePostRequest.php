<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = $this->route('post');
        return auth()->check() && (
                auth()->id() === $post->user_id || auth()->user()->isAdmin()
            );
    }
    public function rules(): array
    {
        $postId = $this->route('post')->id;
        return [
            'title' => ['sometimes', 'required', 'string', 'min:5', 'max:255'],
            'body'  => ['sometimes', 'required', 'string', 'min:100'],
            'slug' => ['sometimes', 'required', 'string', "unique:posts,slug,{$postId}", 'regex:/^[a-z0-9-]+$/'],
            'category_ids'   => ['nullable', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.min'      => 'The post title must be at least 5 characters long.',
            'body.min'       => 'The post body must be at least 100 characters. Please write more content.',
            'slug.regex'     => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'slug.unique'    => 'This slug is already taken by another post.',
            'category_ids.*' => 'One or more selected categories do not exist.',
        ];
    }
}
