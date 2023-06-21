<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Pandu',
            'email' => 'pandu@gmail.com',
            'password' => bcrypt('123'),
            'deleted' => false,
            'no_handphone' => '081112223211',
            'tgl_lahir' => Carbon::parse('2002-08-14'),
        ]);
    }
}
