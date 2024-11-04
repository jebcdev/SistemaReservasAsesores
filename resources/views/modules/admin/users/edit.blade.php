@extends('adminlte::page')

@section('title')
    {{ config('app.name') }}
@stop

@section('content_header')
    <div class="row align-items-center">
        <div class="col-6 d-flex">
            <h1 class="me-auto">
                {{ __('Edit User') }}
            </h1>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
                {{ __('Users Management') }}
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="bg-dark p-2 rounded">
    @includeIf('modules.admin.users.form', [
        'action' => route('admin.users.update', $user),
        'method' => 'PATCH',
    ])
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
