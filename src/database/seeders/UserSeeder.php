<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $search = User::first();

        if(!$search){

            User::create([
                'name' => 'Manuel Alejandro Chavez',
                'email' => 'alejandrotsu23@gmail.com',
                'password' => Hash::make('12345'), // password
                'email_verified_at' => now(),
            ]);

            \App\Models\User::factory(1)->create();
        }
    }
}
