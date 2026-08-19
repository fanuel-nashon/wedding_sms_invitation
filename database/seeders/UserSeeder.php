<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $user = User::firstOrCreate(
            ['email' => 'fanuelnashon1@gmail.com'],
            [
                'name' => 'Fanuel Nashon',
                'password' => bcrypt('change-me-now'),
                'email_verified_at' => now(),
            ]
        );
    }
}
