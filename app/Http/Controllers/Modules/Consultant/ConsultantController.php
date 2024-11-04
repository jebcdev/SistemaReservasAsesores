<?php

namespace App\Http\Controllers\Modules\Consultant;

use App\Enums\PaymentStatusEnum;
use App\Enums\ReservationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $currentConsultantId;

    public function __construct()
    {
        $this->currentConsultantId = Auth::user()->id;
    }

    public function index()
    {
        try {
            $reservations = Reservation::query()
                ->where('consultant_id', $this->currentConsultantId)
                ->with([
                    'user',
                    'consultant',
                ])
                ->orderBy('id', 'DESC')
                ->get();

            return view('modules.consultants.index', [
                'reservations' => $reservations,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $reservation = new Reservation();

            $reservation->load([
                'user',
                'consultant',
            ])
                ->get();

            $users = User::query()
                ->where('role_id', 3)
                ->whereNull('deleted_at')
                ->with([
                    'role',
                    'userDetail',
                    'reservations',
                ])
                ->orderBy('name', 'ASC')
                ->get();


            $reservationStatuses = [
                ReservationStatusEnum::PENDIENTE->value,
                ReservationStatusEnum::CONFIRMADA->value,
                ReservationStatusEnum::PAGADA->value,
                ReservationStatusEnum::CANCELADA->value
            ];

            $paymentStatuses = [
                PaymentStatusEnum::PENDIENTE->value,
                PaymentStatusEnum::PAGADO->value,
                PaymentStatusEnum::FALLIDO->value,
            ];



            return view('modules.consultants.create', [
                'reservation' => $reservation,
                'users' => $users,
                'consultantId' => $this->currentConsultantId,
                'reservationStatuses' => $reservationStatuses,
                'paymentStatuses' => $paymentStatuses,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        try {

            $data = $request->validated();

            $reservation = Reservation::create($data);


            return to_route('consultants.index')->with('sessionMessage', __('Reservation Created Successfully'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        try {
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        try {
            $reservation->load([
                'user',
                'consultant',

            ])
                ->get();

            $users = User::query()
                ->where('role_id', 3)
                ->whereNull('deleted_at')
                ->with([
                    'role',
                    'userDetail',
                    'reservations',
                ])
                ->orderBy('name', 'ASC')
                ->get();

            $reservationStatuses = ReservationStatusEnum::toArray();

            $paymentStatuses =  PaymentStatusEnum::toArray();




            return view('modules.consultants.edit', [
                'reservation' => $reservation,
                'users' => $users,
                'consultantId' => $this->currentConsultantId,
                'reservationStatuses' => $reservationStatuses,
                'paymentStatuses' => $paymentStatuses,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            try {

                $data = $request->validated();

                $reservation->update($data);


                return to_route('consultants.index')->with('sessionMessage', __('Reservation Updated Successfully'));
            } catch (\Throwable $th) {
                throw $th;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();

            return to_route('consultants.index')->with('sessionMessage', __('Reservation Deleted Successfully'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllReservations()
    {
        try {
            // Cargar las reservas con las relaciones necesarias
            $reservations = Reservation::query()
                ->where('reservation_status', '!=', ReservationStatusEnum::CANCELADA)
                ->where('consultant_id', Auth::user()->id)
                ->with([
                    'user.userDetail',  // Cargar detalles del usuario
                    'consultant.userDetail',  // Cargar detalles del consultor
                ])
                ->orderBy('id', 'DESC')
                ->get();

            // Array para guardar los eventos
            $events = [];


            // Formatear las reservas para el calendario
            foreach ($reservations as $reservation) {
                $events[] = [
                    'title' => $reservation->user->name . ' ' . $reservation->user->userDetail->lastname .
                        ' - ' . $reservation->consultant->name . ' ' . $reservation->consultant->userDetail->lastname,
                    'start' => $reservation->reservation_date->format('Y-m-d') . ' ' . $reservation->start_time->format('H:i'),
                    'end' => $reservation->reservation_date->format('Y-m-d') . ' ' . $reservation->end_time->format('H:i'),
                ];
            }


            return response()->json($events);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function calendar()
    {
        try {
            return view('modules.consultants.calendar');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
