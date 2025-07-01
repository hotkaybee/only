<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $employees = Employee::where('is_active', true)->get();
        $cars = Car::where('is_active', true)->get();

        $destinations = [
            'Аэропорт Домодедово',
            'Аэропорт Шереметьево',
            'Центральный офис',
            'Встреча с клиентом',
            'Деловая встреча в центре',
            'Конференция в отеле',
            'Банк ВТБ',
            'Сбербанк',
            'Московская биржа',
            'Деловой центр Москва-Сити',
        ];

        $purposes = [
            'Деловая встреча',
            'Встреча с клиентами',
            'Участие в конференции',
            'Командировка',
            'Трансфер в аэропорт',
            'Служебная поездка',
            'Встреча с партнерами',
            'Участие в переговорах',
        ];

        $statuses = ['pending', 'approved', 'completed', 'cancelled'];

        // Создаем бронирования за последние 30 дней
        for ($i = 0; $i < 50; $i++) {
            $employee = $employees->random();
            $car = $cars->random();

            $startDate = $faker->dateTimeBetween('-30 days', '+30 days');
            $endDate = Carbon::parse($startDate)->addHours($faker->numberBetween(1, 8));

            $status = $faker->randomElement($statuses);
            $approvedBy = null;
            $approvedAt = null;

            if (in_array($status, ['approved', 'completed'])) {
                $approvedBy = $employees->where('position_id', '>=', 4)->random()->id; // Старший менеджер или выше
                $approvedAt = Carbon::parse($startDate)->subDays($faker->numberBetween(1, 7));
            }

            Booking::create([
                'employee_id' => $employee->id,
                'car_id' => $car->id,
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'destination' => $faker->randomElement($destinations),
                'purpose' => $faker->randomElement($purposes),
                'status' => $status,
                'notes' => $faker->optional(0.3)->sentence(),
                'approved_by' => $approvedBy,
                'approved_at' => $approvedAt,
            ]);
        }
    }
}
