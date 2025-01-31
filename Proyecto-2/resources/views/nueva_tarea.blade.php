@extends('plantilla')

@section('titulo', 'Nueva Tarea')

@section('contenido')
<div class="container">
    <h1 class="my-4">Crear Nueva Tarea</h1>
    <form action="{{ route('nueva-tarea') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Mostrar mensaje de error general -->
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Operario -->
        <div class="mb-3">
            <label for="operario" class="form-label">Operario Encargado</label>
            <select class="form-select" name="operario_id" id="operario">
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario->id }}">{{ $operario->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
            <input type="text" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="{{ old('fecha_realizacion') }}">
        </div>

        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-select" name="cliente_id" id="cliente">
                <option value="">Selecciona un cliente</option>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" name="estado" id="estado">
                <option value="">Selecciona un estado</option>
                <option value="F">Finalizado</option>
                <option value="T">Trabajando</option>
                <option value="C">Cancelado</option>
                <option value="E">En Espera</option>
            </select>
        </div>

        <!-- Anotaciones -->
        <div class="mb-3">
            <label for="anotaciones" class="form-label">Anotaciones</label>
            <textarea class="form-control" name="anotaciones" id="anotaciones" rows="3">{{ old('anotaciones') }}</textarea>
        </div>

        <!-- Subida de Resumen PDF -->
        <div class="mb-3">
            <label for="fichero_resumen" class="form-label">Fichero Resumen (PDF)</label>
            <input type="file" class="form-control" name="fichero_resumen" id="fichero_resumen">
        </div>

        <!-- Subida de Fotos -->
        <div class="mb-3">
            <label for="fotos_trabajo" class="form-label">Fotos del Trabajo (Imágenes)</label>
            <input type="file" class="form-control" name="fotos_trabajo[]" id="fotos_trabajo" multiple>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
    </form>
</div>
@endsection