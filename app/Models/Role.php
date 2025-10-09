<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name'];
    // Relasi Many-to-Many dari Role ke User
    // Artinya: satu role bisa dimiliki oleh banyak user
    // 'user_role' adalah tabel pivot penghubung user dan role
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}
