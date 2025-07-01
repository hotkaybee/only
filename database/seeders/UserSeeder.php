<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Администратор',
                'email' => 'admin@company.com',
                'password' => Hash::make('password'),
                'employee_id' => 1, // Генеральный директор
            ],
            [
                'name' => 'Менеджер',
                'email' => 'manager@company.com',
                'password' => Hash::make('password'),
                'employee_id' => 2, // Заместитель генерального директора
            ],
            [
                'name' => 'Сотрудник',
                'email' => 'employee@company.com',
                'password' => Hash::make('password'),
                'employee_id' => 5, // Менеджер
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Создаем пользователей для остальных сотрудников
        $employees = Employee::whereNotIn('id', [1, 2, 5])->get();

        foreach ($employees as $employee) {
            User::create([
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'email' => $employee->email,
                'password' => Hash::make('password'),
                'employee_id' => $employee->id,
            ]);
        }
    }
}
