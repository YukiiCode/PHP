@extends('plantilla')
@section('titulo', 'Editar Tarea')
@section('contenido')
<div class="container">
    <h1 class="my-4">Editar Tarea</h1>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Por favor, corrige los siguientes errores:</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('actualizar-tarea', ['id' => $tarea->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Indica que esta es una solicitud de actualización -->

        <!-- Operario -->
        <div class="mb-3">
            <label for="operario" class="form-label">Operario Encargado <span class="text-danger">*</span></label>
            <select class="form-select @error('operario_id') is-invalid @enderror" name="operario_id" id="operario" required>
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario->id }}" {{ $tarea->operario_id == $operario->id ? 'selected' : '' }}>
                    {{ $operario->nombre }}
                </option>
                @endforeach
            </select>
            @error('operario_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('fecha_realizacion') is-invalid @enderror"
                name="fecha_realizacion" id="fecha_realizacion"
                value="{{ old('fecha_realizacion', \Carbon\Carbon::parse($tarea->fecha_realizacion)->format('Y-m-d')) }}" required>
            @error('fecha_realizacion')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-select" name="cliente_id" id="cliente">
                <option value="">Selecciona un cliente</option>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }} @if($cliente->id == $tarea->cliente->id) echo selected @endif">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
            <select class="form-select @error('estado') is-invalid @enderror" name="estado" id="estado" required>
                <option value="">Selecciona un estado</option>
                <option value="F" {{ $tarea->estado == 'F' ? 'selected' : '' }}>Finalizado</option>
                <option value="T" {{ $tarea->estado == 'T' ? 'selected' : '' }}>Trabajando</option>
                <option value="C" {{ $tarea->estado == 'C' ? 'selected' : '' }}>Cancelado</option>
                <option value="E" {{ $tarea->estado == 'E' ? 'selected' : '' }}>En Espera</option>
            </select>
            @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Anotaciones -->
        <div class="mb-3">
            <label for="anotaciones" class="form-label">Anotaciones</label>
            <textarea class="form-control @error('anotaciones') is-invalid @enderror"
                name="anotaciones" id="anotaciones" rows="3">{{ old('anotaciones', $tarea->anotaciones) }}</textarea>
            @error('anotaciones')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Subida de Resumen PDF -->
        <div class="mb-3">
            <label for="fichero_resumen" class="form-label">Fichero Resumen (PDF)</label>
            <input type="file" class="form-control @error('fichero_resumen') is-invalid @enderror"
                name="fichero_resumen" id="fichero_resumen" accept=".pdf">
            @error('fichero_resumen')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <!-- Mostrar el PDF actual -->
            @if($tarea->fichero_resumen)
            <div class="mt-3">
                <strong>Previsualización del PDF actual:</strong>
                <div class="mt-2">
                    <iframe src="{{ Storage::url($tarea->fichero_resumen) }}"
                        style="width: 70%; height: 500px; border: 1px solid #ccc;"
                        frameborder="0"></iframe>
                </div>
            </div>
            @endif

        </div>

        <!-- Subida de Fotos -->
        <div class="mb-3">
            <label for="fotos_trabajo" class="form-label">Fotos del Trabajo (Imágenes)</label>
            <input type="file" class="form-control @error('fotos_trabajo') is-invalid @enderror"
                name="fotos_trabajo[]" id="fotos_trabajo" multiple accept="image/*">
            @error('fotos_trabajo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($tarea->fotos_trabajo && count($tarea->fotos_trabajo) > 0)
            <div class="mt-2">
                <strong>Fotos actuales:</strong>
                <div class="row">
                    @foreach($tarea->fotos_trabajo as $foto)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 shadow-sm align-items-center">
                            <img src="{{ Storage::url($foto) }}" class="card-img-top img-thumbnail " style="max-height: 100px; width: 70%;">
                            <div class="card-body p-2">
                                <a href="{{ Storage::url($foto) }}" download class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-download me-1"></i> Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Botón de Envío -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" title="Guardar cambios">
                <i class="fas fa-save me-1"></i> Actualizar Tarea
            </button>
            <a href="{{ route('ver-tareas') }}" class="btn btn-secondary" data-bs-toggle="tooltip" title="Cancelar edición">
                <i class="fas fa-times me-1"></i> Cancelar
            </a>
        </div>
    </form>
</div>



@endsection