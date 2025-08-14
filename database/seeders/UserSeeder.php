<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'vendedor',
            'email' => 'vendedor@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
        ]);
    }
}
