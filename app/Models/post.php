<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'is_published',
        'view_count',
    ];
    protected $casts = [
        'is_published' => 'boolean',
        'view_count'   => 'integer',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function statuses(): MorphMany
    {
        return $this->morphMany(Status::class, 'statusable');
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function excerpt(int $length = 150): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->body), $length);
    }
}
