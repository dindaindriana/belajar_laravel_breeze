<?php

namespace Database\Seeders;

use App\Models;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // Menambahkan data awal ke tabel 'roles'
    // Fungsi create() akan langsung menyimpan data ke database
    // Di sini, kita membuat role baru bernama 'admin'

    public function run(): void
    {
        $user = Models\User::create([
            'name' => 'Dinda Fitria Indriana',
            'email' => 'dindaindriana@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Membuat 10 user dummy menggunakan factory
        User::factory(10)->create();

        // Membuat 2 role: admin dan partner
        collect([
            ['name' => 'admin',],
            ['name' => 'partner',],
        ])->each(fn ($role) => Models\Role::create($role));
        
        // Beri role 'admin' ke user pertama
        $user->assignRole(Role::find(1));

        // Ambil user dengan ID 2   
        $user2 = Models\User::find(2);
        
        // Beri role 'partner' ke user kedua
        $user2->assignRole(Role::find(2));
    }
}
