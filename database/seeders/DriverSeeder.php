<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $drivers = [
            [
                'first_name' => 'Иван',
                'last_name' => 'Петров',
                'phone' => '+7 (495) 123-45-67',
                'is_active' => true,
            ],
            [
                'first_name' => 'Алексей',
                'last_name' => 'Сидоров',
                'phone' => '+7 (495) 234-56-78',
                'is_active' => true,
            ],
            [
                'first_name' => 'Михаил',
                'last_name' => 'Козлов',
                'phone' => '+7 (495) 345-67-89',
                'is_active' => true,
            ],
            [
                'first_name' => 'Дмитрий',
                'last_name' => 'Волков',
                'phone' => '+7 (495) 456-78-90',
                'is_active' => true,
            ],
            [
                'first_name' => 'Андрей',
                'last_name' => 'Морозов',
                'phone' => '+7 (495) 567-89-01',
                'is_active' => true,
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }

        // Создаем дополнительных водителей через фабрику
        for ($i = 0; $i < 5; $i++) {
            Driver::create([
                'first_name' => $faker->firstName('male'),
                'last_name' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'is_active' => $faker->boolean(90), // 90% активных
            ]);
        }
    }
}
