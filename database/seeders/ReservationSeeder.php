<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Enums\PaymentStatusEnum;
use App\Enums\ReservationStatusEnum;

class ReservationSeeder extends Seeder
{
    /**
     * Ejecuta los seeds de la base de datos.
     */
    public function run(): void
    {
        
        for ($i = 1; $i <= 50; $i++) {
            // Obtener un user_id de un usuario con role_id 3
            $userId = User::query()->where('role_id', 3)->inRandomOrder()->first()->id;

            // Obtener un consultant_id de un usuario con role_id 2
            $consultantId = User::query()->where('role_id', 2)->inRandomOrder()->first()->id;

            //Fecha aleatoria de la reserva
            $reservationDate=fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d');

            //Hora de Inicio
            $start_time = fake()->numberBetween(8, 16);
            $end_time = $start_time + 1;
            

            // Crear la reserva
            Reservation::create([
                'user_id' => $userId,
                'consultant_id' => $consultantId, // Puede ser null si no hay consultores
                'reservation_date' =>$reservationDate,
                'start_time' => sprintf('%02d:00', $start_time),
                'end_time' => sprintf('%02d:00', $end_time),
                'reservation_status' => fake()->randomElement([
                    ReservationStatusEnum::PENDIENTE->value,
                    ReservationStatusEnum::CONFIRMADA->value,
                    ReservationStatusEnum::PAGADA->value,
                    ReservationStatusEnum::CANCELADA->value,
                ]),
                'total_amount' => rand(1000, 5000) / 100,
                'payment_status' => fake()->randomElement([
                    PaymentStatusEnum::PENDIENTE->value,
                    PaymentStatusEnum::PAGADO->value,
                    PaymentStatusEnum::FALLIDO->value,
                ]),
                'cancellation_reason' => null,
            ]);
        }
    }
}
