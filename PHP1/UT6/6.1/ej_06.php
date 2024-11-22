<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    $mysqli = new mysqli("localhost", "root", "", "bdprovincias");
    $mysqli->set_charset('utf8');

    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $resultado_comunidades = $mysqli->query("SELECT * FROM tbl_comunidadesautonomas");

    $comunidadArray = [];
    while ($comunidad = $resultado_comunidades->fetch_assoc()) {
        $comunidadArray[] = $comunidad;
    }

    echo '<form action="ej_06.php" method="post">
    <label>Seleccione CCAA
    <select name="comunidad" id="comunidad">
        <option value="" hidden>Seleccione una opción</option>';

    foreach ($comunidadArray as $comunidad) {
        echo '<option value="' . $comunidad['id'] . '">' . $comunidad['nombre'] . '</option>';
    }

    echo '</select></label>
      <input type="submit" value="Ver provincias">
      </form>';

    if ($_POST) {
        $comunidad_id = (int)$_POST['comunidad']; 
        echo $comunidadArray[$comunidad_id-1]['nombre'];
        $resultado_provincias = $mysqli->query("
    SELECT nombre as provincias 
    FROM tbl_provincias 
    WHERE comunidad_id = $comunidad_id");

        if ($resultado_provincias) {
            echo "<ul>";
            while ($provincia = $resultado_provincias->fetch_assoc()) {
                echo "<li>" . $provincia['provincias'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Error al obtener provincias: " . $mysqli->error;
        }
    }

    ?>
</body>

</html>