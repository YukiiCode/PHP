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
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}">
            @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni', $empleado->dni) }}">
            @error('dni')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}">
            @error('correo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}">
            @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}">
            @error('direccion')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo">
            @error('tipo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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