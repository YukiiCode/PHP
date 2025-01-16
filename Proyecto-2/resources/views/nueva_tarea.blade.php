@extends('plantilla')

@section('titulo', 'Nueva Tarea')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Crear/Modificar Tarea</h2>
    <!-- Formulario -->
    <form action="" method="POST" enctype="multipart/form-data">

        <!-- Cliente que encarga la tarea -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-select" name="cliente" id="cliente">
                <option value="">Selecciona un cliente</option>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Creacion -->
        <div class="mb-3">
            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
            <input type="text" class="form-control" name="fecha_creacion" id="fecha_creacion" value="{{ old('fecha_creacion') }}">
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
            <input type="text" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="{{ old('fecha_realizacion') }}">
        </div>

        <!-- Operario -->
        <div class="mb-3">
            <label for="operarios" class="form-label">Operario Encargado</label>
            <select class="form-select" name="operario" id="operario">
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario->id }}">{{ $operario->nombre }}</option>
                @endforeach
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