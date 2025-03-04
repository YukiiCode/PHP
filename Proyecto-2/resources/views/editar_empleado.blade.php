@extends('plantilla')

@section('titulo', 'Editar Empleado')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Empleado</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}">
                </div>
                
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni', $empleado->dni) }}">
                </div>
                
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}">
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}">
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}">
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="operario" {{ $empleado->tipo == 'operario' ? 'selected' : '' }}>Operario</option>
                        <option value="administrador" {{ $empleado->tipo == 'administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection