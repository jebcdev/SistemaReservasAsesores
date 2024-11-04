@extends('adminlte::page')

@section('title')
    {{ config('app.name') }}
@stop

@section('content_header')
    <div class="row align-items-center">
        <div class="col-6 d-flex">
            <h1 class="me-auto">
                {{ __('Create Reservations') }}
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

        @includeIf('modules.admin.reservations.form', [
            'action' => route('admin.reservations.store'),
            'method' => 'POST',
        ])

    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">

@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                theme: "classic"
            });
            $('#consultant_id').select2({
                theme: "classic"
            });
            $('#reservation_status').select2({
                theme: "classic"
            });
            $('#payment_status').select2({
                theme: "classic"
            });
        });
    </script>
@stop
