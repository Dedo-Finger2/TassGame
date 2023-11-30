<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        for ($i = 1; $i < 4; $i++) {
            \App\Models\Urgence::factory()->create([
                'name' => "Urgence nº$i",
                'description' => "teste nº$i",
                'exp' => 12 * ($i / 2),
                'coins' => 5.43 * ($i / 2),
            ]);

            \App\Models\Difficulty::factory()->create([
                'name' => "Difficulty nº$i",
                'description' => "teste nº$i",
                'exp' => 13 * ($i / 2),
                'coins' => 4.43 * ($i / 2),
            ]);

            \App\Models\Importance::factory()->create([
                'name' => "Importance nº$i",
                'description' => "teste nº$i",
                'exp' => 15 * ($i / 2),
                'coins' => 8.43 * ($i / 2),
            ]);
        }

    }
}
