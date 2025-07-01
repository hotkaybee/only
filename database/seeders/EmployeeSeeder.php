<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_EN');

        $employees = [
            [
                'first_name' => 'Anna',
                'last_name' => 'Ivanova',
                'email' => 'a.ivanova@company.com',
                'phone' => '+7 (495) 111-11-11',
                'position_id' => 7, // Генеральный директор
                'is_active' => true,
            ],
            [
                'first_name' => 'Sergey',
                'last_name' => 'Sidorov',
                'email' => 's.sidorov@company.com',
                'phone' => '+7 (495) 222-22-22',
                'position_id' => 6, // Заместитель генерального директора
                'is_active' => true,
            ],
            [
                'first_name' => 'Viktoriya Xoreva',
                'last_name' => 'Петрова',
                'email' => 'v.xoreva@company.com',
                'phone' => '+7 (495) 333-33-33',
                'position_id' => 5, // Директор департамента
                'is_active' => true,
            ],
            [
                'first_name' => 'Aleksandr',
                'last_name' => 'Pak',
                'email' => 'a.pak@company.com',
                'phone' => '+7 (495) 444-44-44',
                'position_id' => 4, // Старший менеджер
                'is_active' => true,
            ],
            [
                'first_name' => 'Sergey',
                'last_name' => 'Salnikov',
                'email' => 's.salnikov@company.com',
                'phone' => '+7 (495) 555-55-55',
                'position_id' => 3, // Менеджер
                'is_active' => true,
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        // Создаем дополнительных сотрудников
        $positions = Position::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            Employee::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower(substr($firstName, 0, 1) . '.' . $lastName) . '@company.com',
                'phone' => $faker->phoneNumber,
                'position_id' => $faker->randomElement($positions),
                'is_active' => $faker->boolean(95), // 95% активных
            ]);
        }
    }
}
