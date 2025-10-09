<?php

namespace App\Models;

use App\Enums\StoreStatus;
use App\Observers\StoreObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(StoreObserver::class)]

class Store extends Model
{
    protected $fillable = [
        'logo',
        'name',
        'slug',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => StoreStatus::class,
        ];
    }

    public function user(): BelongsTo //Setiap store pasti ada usernya
    {
        return $this->belongsTo(User::class);
    }
}

