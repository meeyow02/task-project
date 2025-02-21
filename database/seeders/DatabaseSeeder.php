<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(env('DEFAULT_PASSWORD')),
        ]);
        \App\Models\User::factory()->create([
            'role' => 'editor',
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => Hash::make(env('DEFAULT_PASSWORD')),
        ]);
        \App\Models\User::factory()->create([
            'role' => 'viewer',
            'name' => 'Viewer',
            'email' => 'viewer@gmail.com',
            'password' => Hash::make(env('DEFAULT_PASSWORD')),
        ]);

        $this->call([
            BookSeeder::class
        ]);
    }
}
