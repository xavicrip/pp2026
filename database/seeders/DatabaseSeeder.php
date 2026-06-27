<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'email' => 'admin@ecommerce.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->client()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@ecommerce.test',
            'password' => Hash::make('password'),
        ]);
    }
}
