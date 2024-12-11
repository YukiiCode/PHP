@extends('plantilla')

@section('titulo', 'No Autorizado')


@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Acceso No Autorizado</h2>
    <div class="alert alert-danger text-center">
        No tienes permisos para acceder a esta sección.
    </div>
    <div class="text-center">
        <a href="{{ $utiles->myUrl('home') }}" class="btn btn-primary">Volver al home</a>
    </div>
</div>
@endsection