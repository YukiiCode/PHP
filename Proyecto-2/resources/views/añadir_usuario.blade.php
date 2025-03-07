@extends('plantilla')

@section('titulo', 'Añadir Usuario')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Añadir Usuario</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-select" id="tipo_usuario" name="tipo_usuario" onchange="location = this.value;">
                    <option value="">Selecciona un tipo de usuario</option>
                    <option value="{{ route('añadir-usuario', ['tipo' => 'empleado']) }}" {{ request('tipo') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="{{ route('añadir-usuario', ['tipo' => 'cliente']) }}" {{ request('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            @if (request('tipo') == 'empleado')
            <h3 class="text-center mb-4">Formulario para Empleado</h3>
            <form action="{{ route('guardar-empleado') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" id="tipo" name="tipo">
                </div>
                <div class="mb-3">
                    <label for="fecha_alta" class="form-label">Fecha de Alta</label>
                    <input type="date" class="form-control" id="fecha_alta" name="fecha_alta">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Guardar Empleado</button>
                </div>
            </form>
            @elseif (request('tipo') == 'cliente')
            <h3 class="text-center mb-4">Formulario para Cliente</h3>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos">
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection