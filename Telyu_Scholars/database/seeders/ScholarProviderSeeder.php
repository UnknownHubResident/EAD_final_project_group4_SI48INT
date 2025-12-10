<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ScholarProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::create([
            'name' => 'Jasso_study',
            'email' => 'jasso@gmail.com',
            'password' => Hash::make('09876'),
            'email_verified_at' => now(),
            'role' => 'scholar_provider'
        ]);
    }
}
