@extends('adminlte::page')

@section('title')
    {{ config('app.name') }}
@stop

@section('content_header')
    <div class="row align-items-center">
        <div class="col-6 d-flex">
            <h1 class="me-auto">
                {{ __('Reservations Management') }}
            </h1>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <a href="{{ route('consultants.create') }}" class="btn btn-sm btn-primary">
                {{ __('Create Reservations') }}
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
        @includeIf('modules.consultants.table')
        {{-- Table Data --}}


    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('assets/js/jq.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
        });
    </script>
@stop
