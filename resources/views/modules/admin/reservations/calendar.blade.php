@extends('adminlte::page')

@section('title')
    {{ config('app.name') }}
@stop

@section('content_header')
    <div class="row align-items-center">
        <div class="col-6 d-flex">
            <h1 class="me-auto">
                {{ __('Reservations Calendar') }}
            </h1>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-primary">
                {{ __('Reservations Management') }}
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="bg-dark p-2 rounded">

        @if (session('sessionMessage'))
            <div class="alert alert-success m-3">
                {{ session('sessionMessage') }}
            </div>
        @endif

        {{-- Table Data --}}
        <div id="calendar">

        </div>
        {{-- Table Data --}}


    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
@stop

@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                locale: 'es',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },

                events:'{{ route("admin.getAllReservations") }}',
            });

            calendar.render();
        });
    </script>

@stop
