<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class postresource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => Str::limit(strip_tags($this->body), 150),
            'is_published' => (bool) $this->is_published,
            'view_count' => $this->view_count,
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments_count' => $this->whenLoaded('comments', fn() => $this->comments->count()),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
