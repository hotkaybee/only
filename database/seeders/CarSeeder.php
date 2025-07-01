<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\ComfortCategory;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $cars = [
            // Эконом класс
            [
                'brand' => 'Lada',
                'model' => 'Granta',
                'license_plate' => 'А123АА77',
                'year' => 2020,
                'color' => 'Белый',
                'comfort_category_id' => 1,
                'driver_id' => 1,
                'is_active' => true,
                'notes' => 'Экономичный автомобиль для коротких поездок',
            ],
            [
                'brand' => 'Renault',
                'model' => 'Logan',
                'license_plate' => 'В234ВВ77',
                'year' => 2021,
                'color' => 'Серый',
                'comfort_category_id' => 1,
                'driver_id' => 2,
                'is_active' => true,
                'notes' => 'Надежный седан',
            ],
            // Стандарт класс
            [
                'brand' => 'Hyundai',
                'model' => 'Solaris',
                'license_plate' => 'С345СС77',
                'year' => 2022,
                'color' => 'Черный',
                'comfort_category_id' => 2,
                'driver_id' => 3,
                'is_active' => true,
                'notes' => 'Комфортный седан с кондиционером',
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Polo',
                'license_plate' => 'Д456ДД77',
                'year' => 2021,
                'color' => 'Синий',
                'comfort_category_id' => 2,
                'driver_id' => 4,
                'is_active' => true,
                'notes' => 'Немецкое качество и надежность',
            ],
            // Бизнес класс
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'license_plate' => 'Е567ЕЕ77',
                'year' => 2023,
                'color' => 'Белый',
                'comfort_category_id' => 3,
                'driver_id' => 5,
                'is_active' => true,
                'notes' => 'Представительский седан бизнес-класса',
            ],
            [
                'brand' => 'BMW',
                'model' => 'M5',
                'license_plate' => 'К678КК77',
                'year' => 2022,
                'color' => 'Черный',
                'comfort_category_id' => 3,
                'driver_id' => 6,
                'is_active' => true,
                'notes' => 'Спортивный седан премиум-класса',
            ],
            // Премиум класс
            [
                'brand' => 'Mercedes-Benz',
                'model' => 'E-Class',
                'license_plate' => 'М789ММ77',
                'year' => 2023,
                'color' => 'Черный',
                'comfort_category_id' => 4,
                'driver_id' => 7,
                'is_active' => true,
                'notes' => 'Роскошный седан для VIP поездок',
            ],
            [
                'brand' => 'Audi',
                'model' => 'A6',
                'license_plate' => 'Н890НН77',
                'year' => 2023,
                'color' => 'Серый',
                'comfort_category_id' => 4,
                'driver_id' => 8,
                'is_active' => true,
                'notes' => 'Премиальный седан с максимальным комфортом',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }

        // Создаем дополнительные автомобили
        $brands = ['Toyota', 'Honda', 'Nissan', 'Ford', 'Chevrolet', 'Kia', 'Mazda'];
        $models = ['Sedan', 'Hatchback', 'SUV', 'Wagon'];
        $colors = ['Белый', 'Черный', 'Серый', 'Синий', 'Красный', 'Зеленый'];

        $drivers = Driver::where('is_active', true)->pluck('id')->toArray();
        $categories = ComfortCategory::pluck('id')->toArray();

        // Массивы для генерации корректных номеров
        $letters = ['А', 'В', 'Е', 'К', 'М', 'Н', 'О', 'Р', 'С', 'Т', 'У', 'Х'];
        $regions = ['77', '99', '97', '177', '199', '197', '777', '799'];

        for ($i = 0; $i < 10; $i++) {
            if (empty($drivers)) break;

            $driverId = array_splice($drivers, array_rand($drivers), 1)[0];

            // Генерируем корректный номер вида А123БВ77
            $licensePlate = $faker->randomElement($letters) .
                $faker->numberBetween(100, 999) .
                $faker->randomElement($letters) .
                $faker->randomElement($letters) .
                $faker->randomElement($regions);

            Car::create([
                'brand' => $faker->randomElement($brands),
                'model' => $faker->randomElement($models),
                'license_plate' => $licensePlate,
                'year' => $faker->numberBetween(2018, 2025),
                'color' => $faker->randomElement($colors),
                'comfort_category_id' => $faker->randomElement($categories),
                'driver_id' => $driverId,
                'is_active' => $faker->boolean(95), // 95% активных
                'notes' => $faker->optional()->sentence(),
            ]);
        }
    }
}
