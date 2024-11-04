<?php

use App\Enums\PaymentStatusEnum;
use App\Enums\ReservationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('consultant_id')->references('id')->on('users')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('reservation_status', [
                ReservationStatusEnum::PENDIENTE->value,
                ReservationStatusEnum::CONFIRMADA->value,
                ReservationStatusEnum::PAGADA->value,
                ReservationStatusEnum::CANCELADA->value,
            ])->default(ReservationStatusEnum::PENDIENTE->value);

            $table->decimal('total_amount', 12, 2)->nullable();

            $table->enum('payment_status', [
                PaymentStatusEnum::PENDIENTE->value,
                PaymentStatusEnum::PAGADO->value,
                PaymentStatusEnum::FALLIDO->value,
            ])->default(PaymentStatusEnum::PENDIENTE->value);

            $table->text('cancellation_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
