<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'john testman',
            'email' => 'john@telmail.com',
            'password' => Hash::make('pass1234'),
            'role' => 'student',
            'student_number' => '101011220001',
            'study_major' => 'information system',
            'degree_rank' => 'bachelor',
            'year_batch' => '2023',
        ]);
        
        $this->call([
            AdminSeeder::class,
            ScholarProviderSeeder::class,
        ]);
    }
}
