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

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'role' => 'customer', 'is_admin' => false]
        );

        $restaurant = \App\Models\Restaurant::firstOrCreate(['name' => 'NK-EATS']);

        foreach ([
            ['コロッケ定食', 690, '洋食'],
            ['トンカツ定食', 480, '洋食'],
            ['オムライス', 380, '洋食'],
            ['シーフードグラタン', 580, '洋食'],
            ['ハヤシライス', 850, '洋食'],
            ['Chaumin', 880, '洋食'],
            ['ネパール定食', 690, 'ネパール料理'],
            ['モモ', 480, 'ネパール料理'],
            ['ネパール風チャウメン', 380, 'ネパール料理'],
            ['ネパール風ピザ', 580, 'ネパール料理'],
            ['ネパール料理セット', 850, 'ネパール料理'],
        ] as [$name, $price, $category]) {
            \App\Models\Product::updateOrCreate(
                ['restaurant_id' => $restaurant->id, 'name' => $name],
                ['price' => $price, 'category' => $category, 'in_stock' => true, 'is_available' => true]
            );
        }
    }
}
