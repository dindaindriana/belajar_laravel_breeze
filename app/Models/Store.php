<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    protected $fillable = [
        'logo',
        'name',
        'slug',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

