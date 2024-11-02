<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::findOrCreate('admin');
        Role::findOrCreate('officer');
        Role::findOrCreate('general');

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => '12345',
        ])->assignRole('admin');
        User::factory()->create([
            'name' => 'Officer',
            'email' => 'officer@admin.com',
        ])->assignRole('officer');
        User::factory(20)->create();

        $this->call(
            BukuSeeder::class
        );
    }
}
