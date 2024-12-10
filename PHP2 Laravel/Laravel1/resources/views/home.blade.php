@extends('plantilla')

@section('titulo', 'Inicio')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h1 class="display-4 mb-4">Bienvenido al Sistema</h1>
                <p class="lead">Sistema de gestión de tareas</p>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3><i class="fas fa-tasks text-primary"></i></h3>
                                <h5>Gestión de Tareas</h5>
                                <p>Administra todas las tareas del sistema</p>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <a href="{{ $utiles->myUrl('ver-tareas') }}" class="btn btn-primary">Ver tareas</a>
                                    <a href="{{ $utiles->myUrl('nueva-tarea') }}" class="btn btn-success">Nueva tarea</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection