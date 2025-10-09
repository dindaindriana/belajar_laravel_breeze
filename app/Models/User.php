<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stores() : HasMany
    {
        return $this->hasMany(Store::class); // hasMany(Store::class) → relasi One-to-Many Artinya: satu model(satu user) ini bisa punya banyak Store
    }

    public function roles(): BelongsToMany
    {
        // Relasi Many-to-Many dari User ke Role
        // Artinya: satu user bisa punya banyak role
        // Menggunakan tabel pivot 'user_role' yang sama
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function assignRole(Role $role): Model
    {
        return $this->roles()->save($role);
    }
}   
 