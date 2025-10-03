<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;
// use Illuminate\Auth\Access\Response;

class StorePolicy
{
    public function update(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }

    // public function update(User $user, Store $store): Response
    // {
    //     return $user->id === $store->user_id ? Response::allow() : Response::denyAsNotFound();
    // } //ini versi customize return to 404 page

    public function destroy(User $user, Store $store): bool
    {
        return $this->update($user, $store);
    }

}


// | - Authorization = Konsep izin (permission) di Laravel.
// |   Authentication = memastikan SIAPA user (login),
// |   Authorization  = memastikan APA yang boleh user lakukan.
// |
// | - Gate = Cara sederhana untuk bikin aturan izin (inline rule).
// |   Biasanya ditulis di AppServiceProvider@boot.
// |   Contoh: Gate::define('update-store', fn($user, $store) => $user->id === $store->user_id);
// |   Lalu dipakai dengan Gate::authorize('update-store', $store);
// |
// | - Policy = Kelas khusus untuk otorisasi per model.
// |   Lebih terstruktur dan rapi kalau aturan banyak.
// |   Dibuat dengan: php artisan make:policy StorePolicy --model=Store
// |   Contoh: $this->authorize('update', $store);