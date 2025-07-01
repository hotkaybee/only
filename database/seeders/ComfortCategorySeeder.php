<?php

namespace Database\Seeders;

use App\Models\ComfortCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComfortCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Эконом', 'level' => 1, 'description' => 'Базовый уровень комфорта'],
            ['name' => 'Стандарт', 'level' => 2, 'description' => 'Средний уровень комфорта'],
            ['name' => 'Бизнес', 'level' => 3, 'description' => 'Высокий уровень комфорта'],
            ['name' => 'Премиум', 'level' => 4, 'description' => 'Максимальный уровень комфорта'],
        ];

        foreach ($categories as $category) {
            ComfortCategory::create($category);
        }
    }
}
