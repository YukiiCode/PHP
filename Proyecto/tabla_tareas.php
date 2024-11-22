<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <!-- Incluimos Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            width: 100px; /* Ancho fijo para los botones */
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Gestión de Tareas</h1>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>NIF/CIF</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Descripción Tarea</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Población</th>
                    <th>Código Postal</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php cargar_tareas(); ?>
            </tbody>
        </table>
    </div>
</body>

<?php
function cargar_tareas()
{
    $consulta = "SELECT id, nif_cif, persona_contacto, telefono_contacto, descripcion, correo_contacto, direccion, poblacion, codigo_postal FROM tareas";
    $mysqli = new mysqli("localhost", "root", "", "gestion_tareas");
    $mysqli->set_charset('utf8');

    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
        $tabla = $mysqli->query($consulta);
        $mostrarDetalles = isset($_GET['mostrar']) ? $_GET['mostrar'] : null;

        while ($fila = $tabla->fetch_assoc()) {
            $id = $fila['id'];
            // Mostrar fila de tarea
            echo "<tr>";
            foreach ($fila as $columna => $valor) {
                echo "<td>$valor</td>";
            }
            // Cambiar el enlace para alternar la visibilidad de la fila de detalles
            if ($mostrarDetalles == $id) {
                // Si la fila de detalles está abierta, el enlace debe cerrarla
                echo "<td><a href='?mostrar=0' class='btn btn-info btn-sm btn-custom'>Ver menos</a></td>";
            } else {
                // Si la fila de detalles está cerrada, el enlace debe abrirla
                echo "<td><a href='?mostrar=$id' class='btn btn-info btn-sm btn-custom'>Ver más</a></td>";
            }

            echo "<td><button class='btn btn-warning btn-sm'>Modificar</button></td>
                  <td><button class='btn btn-danger btn-sm'>Eliminar</button></td>";
            echo "</tr>";

            // Mostrar fila de detalles si corresponde
            if ($mostrarDetalles == $id) {
                echo "<tr class='table-secondary'>
                        <td colspan='10'>
                            <strong>Detalles adicionales para la tarea $id:</strong><br>
                            Información completa de la tarea aquí...
                        </td>
                      </tr>";
            }
        }
    }
}
?>

</html>
