
@extends('adminlte::page')

@section('title')
	{{ config('app.name') }}
@stop

@section('content_header')
<div class="row align-items-center">
    <div class="col-6 d-flex">
        <h1 class="me-auto">
            {{__('Administration')}}
        </h1>
    </div>
    <div class="col-6 d-flex justify-content-end">
        <a href="{{ route('admin.index') }}" class="btn btn-sm btn-primary">
            {{__('Administration')}}
        </a>
    </div>
</div>
@stop

@section('content')
    <p>
		Welcome to this beautiful admin panel.
	</p>
@stop

@section('css')
	{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
	{{-- <script> console.log('Hi!'); </script> --}}
@stop