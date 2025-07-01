<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ComfortCategorySeeder::class,
            PositionSeeder::class,
            DriverSeeder::class,
            CarSeeder::class,
            EmployeeSeeder::class,
            UserSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
