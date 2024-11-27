<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <form action="{{ route('procesar.tarea') }}" method="post">
            @csrf <!-- Necesario para proteger el formulario -->
            <fieldset class="border p-4 rounded">
                <legend class="text-center fw-bold">Crear Tarea</legend>

                <!-- Campos del formulario -->
                <div class="mb-3">
                    <label for="nif_cif" class="form-label">NIF/CIF</label>
                    <input type="text" class="form-control" name="nif_cif" id="nif_cif" value="{{ old('nif_cif') }}">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>
