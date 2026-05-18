<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }
    public function hasPermission(string $slug): bool
    {
        if ($this->permissions->contains('slug', $slug)) {
            return true;
        }
        if ($this->role) {
            return $this->role->permissions->contains('slug', $slug);
        }

        return false;
    }
}
