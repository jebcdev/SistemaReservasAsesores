@extends('adminlte::page')

@section('title')
    {{ config('app.name') }}
@stop

@section('content_header')
    <div class="row align-items-center">
        <div class="col-6 d-flex">
            <h1 class="me-auto">
                {{ __('User Details') }}:
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

        {{-- Image if Exists --}}
        @if ($user->userDetail && $user->userDetail->image)
            <div class="mb-3 text-center rounded">
                <img src="{{ asset('assets/img/users/' . $user->userDetail->image) }}" alt="{{ $user->name }}"
                    class="img-fluid img-thumbnail rounded-circle" style="width: 200px">
            </div>
        @endif
        {{-- Image if Exists --}}


        {{-- Name LastName --}}
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                    readonly>
            </div>

            <div class="col">
                <label for="lastname" class="form-label">{{ __('Lastname') }}</label>
                <input type="text" class="form-control" id="lastname" name="lastname"
                    value="{{ $user->userDetail->lastname }}" readonly>
            </div>


        </div>
        {{-- Name LastName --}}

        {{-- Phone Email --}}
        <div class="row">
            <div class="col">
                <label for="phone" class="form-label">{{ __('Phone') }}</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ $user->userDetail->phone ?? '' }}" readonly>
            </div>
            <div class="col">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                    readonly>
            </div>
        </div>
        {{-- Phone Email --}}

        {{-- Image and Role --}}
        <div class=" mb-3">



            <label for="role_id" class="form-label">{{ __('Role') }}</label>
            <input type="text" class="form-control text-uppercase" id="role_id" name="role_id"
                value="{{ $user->role->name }}" readonly>


        </div>

        {{-- Image and Role --}}


        {{-- All Errors Div --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- All Errors Div --}}


        {{-- Action Buttons --}}
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('DELETE')

            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> &nbsp; {{ __('Edit') }}
            </a>

            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estas Seguro?')">
                <i class="fas fa-trash-alt"></i> &nbsp; {{ __('Delete') }}
            </button>
        </form>
        {{-- Action Buttons --}}



    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
