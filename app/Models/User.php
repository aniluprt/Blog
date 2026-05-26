<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isGuest()
    {
        return !$this->exists;
    }

    public function hasPermission($permissionName)
    {
        // Check direct user permissions
        if ($this->permissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        if ($this->role && $this->role->permissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        return false;
    }
}
