@extends('plantilla')

@section('titulo', 'Nueva Tarea')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Crear/Modificar Tarea</h2>
    <!-- Formulario -->
    <form action="" method="POST" enctype="multipart/form-data">

        <!-- Campo oculto para el ID de la tarea (solo en edición) -->
        @if(isset($tarea['id']))
        <input type="hidden" name="id" value="{{ $tarea['id'] }}">
        @endif

        <!-- Errores Generales -->
        {!! $utiles->mostrarErrores('general', $errores ?? []) !!}

        <!-- NIF/CIF -->
        <div class="mb-3">
            <label for="nif_cif" class="form-label">NIF/CIF</label>
            <input type="text" class="form-control" name="nif_cif" id="nif_cif" value="{{ $tarea['nif_cif'] ?? $utiles->mostrarDatosAnteriores('nif_cif') }}">
            {!! $utiles->mostrarErrores('nif_cif', $errores ?? []) !!}
        </div>

        <!-- Nombre y Apellidos -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $tarea['nombre'] ?? $utiles->mostrarDatosAnteriores('nombre') }}">
            {!! $utiles->mostrarErrores('nombre', $errores ?? []) !!}
        </div>

        <!-- Teléfono -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" id="telefono" value="{{ $tarea['telefono_contacto'] ?? $utiles->mostrarDatosAnteriores('telefono') }}">
            {!! $utiles->mostrarErrores('telefono', $errores ?? []) !!}
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control" name="email" id="email" value="{{ $tarea['email'] ?? $utiles->mostrarDatosAnteriores('email') }}">
            {!! $utiles->mostrarErrores('email', $errores ?? []) !!}
        </div>

        <!-- Dirección -->
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" name="direccion" id="direccion" value="{{ $tarea['direccion'] ?? $utiles->mostrarDatosAnteriores('direccion') }}">
            {!! $utiles->mostrarErrores('direccion', $errores ?? []) !!}
        </div>

        <!-- Población y Código Postal -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="poblacion" class="form-label">Población</label>
                <input type="text" class="form-control" name="poblacion" id="poblacion" value="{{ $tarea['poblacion'] ?? $utiles->mostrarDatosAnteriores('poblacion') }}">
                {!! $utiles->mostrarErrores('poblacion', $errores ?? []) !!}
            </div>
            <div class="col-md-6 mb-3">
                <label for="codigo_postal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" value="{{ $tarea['codigo_postal'] ?? $utiles->mostrarDatosAnteriores('codigo_postal') }}">
                {!! $utiles->mostrarErrores('codigo_postal', $errores ?? []) !!}
            </div>
        </div>

        <!-- Provincia -->
        <div class="mb-3">
            <label for="provincias" class="form-label">Provincia</label>
            <select class="form-select" name="provincia" id="provincias">
                <option value="">Selecciona una provincia</option>
                {!! $utiles->cargarProvincias($provincias ?? [], $selectedProvincia ?? null) !!}
            </select>
            {!! $utiles->mostrarErrores('provincia', $errores ?? []) !!}
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" name="estado" id="estado">
                <option value="">Selecciona un estado</option>
                {!! $utiles->cargarEstados($estados ?? [], $selectedEstado ?? null) !!}
            </select>
            {!! $utiles->mostrarErrores('estado', $errores ?? []) !!}
        </div>

        <!-- Fecha de Creacion -->
        <div class="mb-3">
            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
            <input type="text" class="form-control" name="fecha_creacion" id="fecha_creacion" value="{{ $tarea['fecha_creacion'] ?? $utiles->mostrarDatosAnteriores('fecha_creacion') }}">
            {!! $utiles->mostrarErrores('fecha_creacion', $errores ?? []) !!}
        </div>

        <!-- Fecha de Realización -->
        <div class="mb-3">
            <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
            <input type="text" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="{{ $tarea['fecha_realizacion'] ?? $utiles->mostrarDatosAnteriores('fecha_realizacion') }}">
            {!! $utiles->mostrarErrores('fecha_realizacion', $errores ?? []) !!}
        </div>

        <!-- Operario -->
        <div class="mb-3">
            <label for="operarios" class="form-label">Operario Encargado</label>
            <select class="form-select" name="operario" id="operario">
                <option value="">Selecciona un operario</option>
                @foreach ($operarios as $operario)
                <option value="{{ $operario['id'] }}" {{ $operario['id'] == ($selectedOperario ?? '') ? 'selected' : '' }}>
                    {{ $operario['nombre_usuario'] }}
                </option>
                @endforeach
            </select>
            {!! $utiles->mostrarErrores('operario', $errores ?? []) !!}
        </div>

        <!-- Anotaciones Anteriores -->
        <div class="mb-3">
            <label for="anotaciones_anteriores" class="form-label">Anotaciones Anteriores</label>
            <textarea class="form-control" name="anotaciones_anteriores" id="anotaciones_anteriores">{{ $tarea['anotaciones_anteriores'] ?? $utiles->mostrarDatosAnteriores('anotaciones_anteriores') }}</textarea>
        </div>

        <!-- Anotaciones Posteriores -->
        <div class="mb-3">
            <label for="anotaciones_posteriores" class="form-label">Anotaciones Posteriores</label>
            <textarea class="form-control" name="anotaciones_posteriores" id="anotaciones_posteriores">{{ $tarea['anotaciones_posteriores'] ?? $utiles->mostrarDatosAnteriores('anotaciones_posteriores') }}</textarea>
        </div>

        <!-- Subida de Resumen PDF -->
        <div class="mb-3">
            <label for="fichero_resumen" class="form-label">Fichero Resumen (PDF)</label>
            <input type="file" class="form-control" name="fichero_resumen" id="fichero_resumen">
            {!! $utiles->mostrarErrores('fichero_resumen', $errores ?? []) !!}
        </div>

        <!-- Subida de Fotos -->
        <div class="mb-3">
            <label for="fotos_trabajo" class="form-label">Fotos del Trabajo (Imágenes)</label>
            <input type="file" class="form-control" name="fotos_trabajo[]" id="fotos_trabajo" multiple>
            {!! $utiles->mostrarErrores('fotos_trabajo', $errores ?? []) !!}
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
    </form>
</div>
@endsection