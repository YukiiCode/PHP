<a href="index.php">Volver</a>
<br>

<?php

$mysqli = new mysqli("localhost", "root", "", "bdprovincias");
$mysqli->set_charset('utf8');

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$resultado_comunidades = $mysqli->query("SELECT nombre FROM tbl_comunidadesautonomas");

$comunidadArray = [];
while ($comunidad = $resultado_comunidades->fetch_assoc()) {
    $comunidadArray[] = $comunidad;
}

foreach ($comunidadArray as $ncom) {
    echo $ncom['nombre'] . "<br>";
}

?>

