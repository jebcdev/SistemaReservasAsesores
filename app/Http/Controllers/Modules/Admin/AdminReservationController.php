<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Enums\PaymentStatusEnum;
use App\Enums\ReservationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\User;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $reservations = Reservation::query()->with([
                'user',
                'consultant',
            ])
                ->orderBy('id', 'DESC')
                ->get();

            return view('modules.admin.reservations.index', [
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

            $consultants = User::query()
                ->where('role_id', 2)
                ->whereNull('deleted_at')
                ->with([
                    'role',
                    'userDetail',
                    'consultantReservations',
                ])
                ->orderBy('name', 'ASC')
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



            return view('modules.admin.reservations.create', [
                'reservation' => $reservation,
                'users' => $users,
                'consultants' => $consultants,
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


            return to_route('admin.reservations.index')->with('sessionMessage', __('Reservation Created Successfully'));
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

            $consultants = User::query()
                ->where('role_id', 2)
                ->whereNull('deleted_at')
                ->with([
                    'role',
                    'userDetail',
                    'consultantReservations',
                ])
                ->orderBy('name', 'ASC')
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




            return view('modules.admin.reservations.edit', [
                'reservation' => $reservation,
                'users' => $users,
                'consultants' => $consultants,
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


                return to_route('admin.reservations.index')->with('sessionMessage', __('Reservation Updated Successfully'));
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

            return to_route('admin.reservations.index')->with('sessionMessage', __('Reservation Deleted Successfully'));
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
            return view('modules.admin.reservations.calendar');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
