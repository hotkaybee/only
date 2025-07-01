<?php

namespace Database\Seeders;

use App\Models\ComfortCategory;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $positions = [
            'Специалист',
            'Ведущий специалист',
            'Менеджер',
            'Старший менеджер',
            'Директор департамента',
            'Заместитель генерального директора',
            'Генеральный директор',
        ];

        foreach ($positions as $position) {
            Position::create(['name' => $position]);
        }

        // Настраиваем доступ должностей к категориям комфорта
        $positionComfortAccess = [
            'Специалист' => [1], // Только эконом
            'Ведущий специалист' => [1, 2], // Эконом и стандарт
            'Менеджер' => [1, 2], // Эконом и стандарт
            'Старший менеджер' => [1, 2, 3], // До бизнес класса
            'Директор департамента' => [1, 2, 3], // До бизнес класса
            'Заместитель генерального директора' => [1, 2, 3, 4], // Все категории
            'Генеральный директор' => [1, 2, 3, 4], // Все категории
        ];

        foreach ($positionComfortAccess as $positionName => $categoryLevels) {
            $position = Position::where('name', $positionName)->first();
            $categories = ComfortCategory::whereIn('level', $categoryLevels)->get();

            foreach ($categories as $category) {
                DB::table('position_comfort_categories')->insert([
                    'position_id' => $position->id,
                    'comfort_category_id' => $category->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
