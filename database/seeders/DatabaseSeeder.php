<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::create([
            'role_name' => 'Admin',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        User::create([
            'full_name' => 'Pandu',
            'identity' => '3302213213213',
            'phone_number' => '081112223211',
            'email' => 'pandu@gmail.com',
            'address' => 'jl. apa ya',
            'is_group' => false,
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
    }
}
