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

        \App\Models\User::factory()->create([
            'name' => 'Greg',
            'email' => 'user@user',
            'password' => bcrypt('123'),
            'coins' => 2,
        ]);

        \App\Models\Powerup::factory()->create([
            'name' => 'Coin v1',
            'price' => 1,
            'type' => 'coins',
            'uses' => 3,
            'multiplier' => 2,
            'description' => 'legal',
        ]);

        \App\Models\Powerup::factory()->create([
            'name' => 'Exp v1',
            'price' => 1,
            'type' => 'exp',
            'uses' => 3,
            'multiplier' => 2,
            'description' => 'legal',
        ]);

        // ? [UPGRADES] ? \\
        \App\Models\Upgrade::factory()->create([
            'name' => 'Better Coin Bag',
            'price' => 15,
            'level' => 1,
            'buy_limit' => 3,
            'price_multiplier_per_buy' => 2.5,
            'multiplier' => 1.2,
            'action_value' => 25,
            'description' => 'legal',
        ]);

        \App\Models\Upgrade::factory()->create([
            'name' => 'Better Powerup Bag',
            'price' => 30,
            'level' => 2,
            'buy_limit' => 5,
            'price_multiplier_per_buy' => 3.5,
            'multiplier' => 1,
            'action_value' => 1,
            'description' => 'legal',
        ]);

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

        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Task::factory()->create([
                'name' => "Task nº$i",
                'recurring' => false,
                'description' => "task desc nº$i",
                'importance_id' => 1,
                'urgence_id' => 1,
                'difficulty_id' => 1,
                'user_id' => 1,
                'coins' => 10,
                'exp' => 10,
            ]);
        }

    }
}
