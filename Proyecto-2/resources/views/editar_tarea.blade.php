@extends('plantilla')
@section('titulo', 'Editar Tarea')
@section('contenido')
<div class="container">
    <h1 class="my-4">Editar Tarea</h1>
    <form action="{{ route('actualizar-tarea', ['id' => $tarea->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Indica que esta es una solicitud de actualización -->

        <!-- Operario -->
        <div class="mb-3">
            <label for="operario" class="form-label">Operario Encargado</label>
            <select class="form-select" name="operario_id" id="operario">
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario->id }}" {{ $tarea->operario_id == $operario->id ? 'selected' : '' }}>
                    {{ $operario->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
            <input type="text" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="{{ old('fecha_realizacion', $tarea->fecha_realizacion) }}">
        </div>

        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <p>{{ $tarea->cliente->nombre ?? 'Sin cliente asignado' }}</p>
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" name="estado" id="estado">
                <option value="">Selecciona un estado</option>
                <option value="F" {{ $tarea->estado == 'F' ? 'selected' : '' }}>Finalizado</option>
                <option value="T" {{ $tarea->estado == 'T' ? 'selected' : '' }}>Trabajando</option>
                <option value="C" {{ $tarea->estado == 'C' ? 'selected' : '' }}>Cancelado</option>
                <option value="E" {{ $tarea->estado == 'E' ? 'selected' : '' }}>En Espera</option>
            </select>
        </div>

        <!-- Anotaciones -->
        <div class="mb-3">
            <label for="anotaciones" class="form-label">Anotaciones</label>
            <textarea class="form-control" name="anotaciones" id="anotaciones" rows="3">{{ old('anotaciones', $tarea->anotaciones) }}</textarea>
        </div>

        <!-- Subida de Resumen PDF -->
        <div class="mb-3">
            <label for="fichero_resumen" class="form-label">Fichero Resumen (PDF)</label>
            <input type="file" class="form-control" name="fichero_resumen" id="fichero_resumen">
            @if($tarea->fichero_resumen)
            <small class="text-muted d-block mt-2">
                Archivo actual: <a href="{{ Storage::url($tarea->fichero_resumen) }}" target="_blank">{{ basename($tarea->fichero_resumen) }}</a>
            </small>
            @endif
        </div>

        <!-- Subida de Fotos -->
        <div class="mb-3">
            <label for="fotos_trabajo" class="form-label">Fotos del Trabajo (Imágenes)</label>
            <input type="file" class="form-control" name="fotos_trabajo[]" id="fotos_trabajo" multiple>
            
            @if($tarea->fotos_trabajo)
            <div class="mt-2">
                <strong>Fotos actuales:</strong>    
                <div class="row">
                    @foreach($tarea->fotos_trabajo as $foto)
                    <div class="col-md-3 mb-3">
                        <img src="{{ Storage::url($foto) }}" class="img-thumbnail" style="max-height: 100px;">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
        <a href="{{ route('ver-tareas') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection