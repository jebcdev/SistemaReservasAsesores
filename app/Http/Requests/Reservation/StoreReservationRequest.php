<?php

namespace App\Http\Requests\Reservation;

use App\Enums\PaymentStatusEnum;
use App\Enums\ReservationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role_id', 3),
            ],
            'consultant_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role_id', 2),
            ],
            'reservation_date' => [
                'required',
                'date',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:08:00',
                'before_or_equal:17:00',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
                'before_or_equal:17:00',
            ],
            'reservation_status' => [
                'required',
                Rule::in([
                    ReservationStatusEnum::PENDIENTE->value,
                    ReservationStatusEnum::CONFIRMADA->value,
                    ReservationStatusEnum::PAGADA->value,
                    ReservationStatusEnum::CANCELADA->value,
                ]),
            ],
            'total_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'payment_status' => [
                'required',
                Rule::in([
                    PaymentStatusEnum::PENDIENTE->value,
                    PaymentStatusEnum::PAGADO->value,
                    PaymentStatusEnum::FALLIDO->value,
                ]),
            ],
            'cancellation_reason' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Mensajes de validación en español.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.integer' => 'El usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'consultant_id.required' => 'El consultor es obligatorio.',
            'consultant_id.integer' => 'El consultor debe ser un número entero.',
            'consultant_id.exists' => 'El consultor seleccionado no existe.',
            'reservation_date.required' => 'La fecha de la reserva es obligatoria.',
            'reservation_date.date' => 'La fecha de la reserva debe ser una fecha válida.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'start_time.date_format' => 'La hora de inicio debe estar en el formato HH:MM.',
            'end_time.required' => 'La hora de fin es obligatoria.',
            'end_time.date_format' => 'La hora de fin debe estar en el formato HH:MM.',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'reservation_status.required' => 'El estado de la reserva es obligatorio.',
            'reservation_status.in' => 'El estado de la reserva seleccionado no es válido.',
            'total_amount.numeric' => 'El monto total debe ser un número.',
            'total_amount.min' => 'El monto total debe ser mayor o igual a 0.',
            'payment_status.required' => 'El estado de pago es obligatorio.',
            'payment_status.in' => 'El estado de pago seleccionado no es válido.',
            'cancellation_reason.string' => 'La razón de cancelación debe ser un texto.',
        ];
    }
}
