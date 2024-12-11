@extends('plantilla')

@section('titulo', 'Confirmar Eliminación')

@section('contenido')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Confirmar Eliminación</h3>
        </div>
        <div class="card-body">
            <p>¿Estás seguro de que deseas eliminar esta tarea?</p>
            <p><strong>Nombre:</strong> {{ $tarea['nombre'] }}</p>
            <p><strong>Descripción:</strong> {{ $tarea['descripcion'] }}</p>
            <p><strong>Fecha:</strong> {{ $tarea['fecha_creacion'] }}</p>
            <p><strong>Estado:</strong> {{ $tarea['estado'] }}</p>
            <p><strong>Responsable:</strong> {{ $tarea['operario_encargado'] }}</p>

            <form method="POST" action="">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <a href="{{ $utiles->myUrl('/ver-tareas') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection