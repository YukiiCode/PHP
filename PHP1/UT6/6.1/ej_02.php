<?php

$mysqli = new mysqli("localhost", "root", "", "bdprovincias");
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$resultado = $mysqli->query("SELECT nombre FROM tbl_comunidadesautonomas");

while ($fila = $resultado->fetch_assoc()) {
    echo $fila['nombre'] . "<br>";
}
