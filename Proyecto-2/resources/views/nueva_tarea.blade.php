@extends('plantilla')

@section('titulo', 'Nueva Tarea')

@section('contenido')
<div class="container">
    <h1 class="my-4">Crear Nueva Tarea</h1>
    <form action="{{ route('nueva-tarea') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Mostrar mensaje de error general -->
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Operario -->
        <div class="mb-3">
            <label for="operario" class="form-label">Operario Encargado</label>
            <select class="form-select @error('operario_id') is-invalid @enderror" name="operario_id" id="operario">
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario->id }}" {{ old('operario_id') == $operario->id ? 'selected' : '' }}>{{ $operario->nombre }}</option>
                @endforeach
            </select>
            @error('operario_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
            <input type="text" class="form-control @error('fecha_realizacion') is-invalid @enderror" name="fecha_realizacion" id="fecha_realizacion" value="{{ old('fecha_realizacion') }}">
            @error('fecha_realizacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-select @error('cliente_id') is-invalid @enderror" name="cliente_id" id="cliente">
                <option value="">Selecciona un cliente</option>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select @error('estado') is-invalid @enderror" name="estado" id="estado">
                <option value="">Selecciona un estado</option>
                <option value="F" {{ old('estado') == 'F' ? 'selected' : '' }}>Finalizado</option>
                <option value="T" {{ old('estado') == 'T' ? 'selected' : '' }}>Trabajando</option>
                <option value="C" {{ old('estado') == 'C' ? 'selected' : '' }}>Cancelado</option>
                <option value="A" {{ old('estado') == 'A' ? 'selected' : '' }}>Por Aprobar</option>
                <option value="E" {{ old('estado') == 'E' ? 'selected' : '' }}>En Espera</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Anotaciones -->
        <div class="mb-3">
            <label for="anotaciones" class="form-label">Anotaciones</label>
            <textarea class="form-control @error('anotaciones') is-invalid @enderror" name="anotaciones" id="anotaciones" rows="3">{{ old('anotaciones') }}</textarea>
            @error('anotaciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Subida de Resumen PDF -->
        <div class="mb-3">
            <label for="fichero_resumen" class="form-label">Fichero Resumen (PDF, DOC, DOCX)</label>
            <input type="file" class="form-control @error('fichero_resumen') is-invalid @enderror" name="fichero_resumen" id="fichero_resumen">
            @error('fichero_resumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Subida de Fotos -->
        <div class="mb-3">
            <label for="fotos_trabajo" class="form-label">Fotos del Trabajo (JPG, PNG, GIF - Max: 2MB)</label>
            <input type="file" class="form-control @error('fotos_trabajo.*') is-invalid @enderror" name="fotos_trabajo[]" id="fotos_trabajo" multiple>
            @error('fotos_trabajo.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
    </form>
</div>
@endsection