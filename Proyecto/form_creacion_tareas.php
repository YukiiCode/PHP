<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?= $errores = null ?>
    <div class="container mt-5">
        <form action="form_creacion_tareas.php" method="post">
            <fieldset class="border p-4 rounded">
                <legend class="text-center fw-bold">Crear Tarea</legend>

                <div class="mb-3">
                    <label for="nif_cif" class="form-label">NIF/CIF</label> <?= mostrarErrores('nif_cif', $errores) ?>
                    <input type="text" class="form-control" name="nif_cif" id="nif_cif" value="<?= valorPost('nif_cif') ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="apellidos" class="form-label">Apellidos <?= mostrarErrores('apellidos', $errores) ?></label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= valorPost('apellidos') ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre <?= mostrarErrores('nombre', $errores) ?></label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?= valorPost('nombre') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono <?= mostrarErrores('telefono', $errores) ?></label>
                    <input type="text" class="form-control" name="telefono" id="telefono" value="<?= valorPost('telefono') ?>">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción <?= mostrarErrores('descripcion', $errores) ?></label>
                    <textarea class="form-control" name="descripcion" id="descripcion" value="<?= valorPost('descripcion') ?>"></textarea>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico <?= mostrarErrores('email', $errores) ?></label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= valorPost('email') ?>">
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="<?= valorPost('direccion') ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="poblacion" class="form-label">Población</label>
                        <input type="text" class="form-control" name="poblacion" id="poblacion" value="<?= valorPost('poblacion') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" value="<?= valorPost('codigo_postal') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="provincias" class="form-label">Provincia</label>
                    <select class="form-select" name="provincia" id="provincias">
                        <option value="">Selecciona una provincia</option>
                        <!-- Opciones de provincias -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" name="estado" id="estado" value="<?= valorPost('estado') ?>">
                </div>

                <div class="mb-3">
                    <label for="fecha_creacion" class="form-label">Fecha de creación</label>
                    <input type="text" class="form-control" name="fecha_creacion" id="fecha_creacion" value="<?= valorPost('fecha_creacion') ?>">
                </div>

                <div class="mb-3">
                    <label for="operarios" class="form-label">Operario encargado</label>
                    <select class="form-select" name="operario" id="operario">
                        <option value="">Selecciona un operario</option>
                        <!-- Opciones de operarios -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_realizacion" class="form-label">Fecha de realización</label>
                    <input type="text" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="<?= valorPost('fecha_realizacion') ?>">
                </div>

                <div class="mb-3">
                    <label for="anotaciones_anteriores" class="form-label">Anotaciones anteriores (Opcional)</label>
                    <textarea class="form-control" name="anotaciones_anteriores" id="anotaciones_anteriores" value="<?= valorPost('anotaciones_anteriores') ?>"></textarea>
                </div>

                <div class="mb-3">
                    <label for="anotaciones_posteriores" class="form-label">Anotaciones posteriores (Opcional)</label>
                    <textarea class="form-control" name="anotaciones_posteriores"
                        id="anotaciones_posteriores" value="<?= valorPost('anotaciones_posteriores') ?>"></textarea>
                </div>

                <div class="mb-3">
                    <label for="Info" class="form-label">Importante: Los ficheros adicionales con información de la
                        tarea se podran subir en cuanto esté aprobada</label>
                </div>

                <div class="text-center">
                    <a href="pagina_principal.html"><button type="button" class="btn btn-warning">Volver</button></a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                </div>

            </fieldset>
        </form>
    </div>
    <?php
    include('filtrado_tareas.php');
    if ($_POST) {
        $errores = validarFormulario();
    }

    function valorPost($var)
    {
        if (isset($_POST[$var]))
            return htmlspecialchars($_POST[$var]);
        else return "";
    }

    function mostrarErrores($campo, $errores)
    {
        if (isset($errores[$campo]))
            echo "<div class='text-danger'>{$errores[$campo]}</div>";
    }
    ?>
</body>

</html>