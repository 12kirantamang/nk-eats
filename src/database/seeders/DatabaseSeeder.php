<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $restaurant = \App\Models\Restaurant::firstOrCreate(['name' => 'NK-EATS']);

        foreach ([
            ['コロッケ定食', 690, '洋食'],
            ['トンカツ定食', 480, '洋食'],
            ['オムライス', 380, '洋食'],
            ['シーフードグラタン', 580, '洋食'],
            ['ハヤシライス', 850, '洋食'],
        ] as [$name, $price, $category]) {
            \App\Models\Product::firstOrCreate(
                ['restaurant_id' => $restaurant->id, 'name' => $name],
                ['price' => $price, 'category' => $category, 'in_stock' => true]
            );
        }
    }
}
