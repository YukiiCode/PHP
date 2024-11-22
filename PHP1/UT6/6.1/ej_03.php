<?php

$mysqli = new mysqli("localhost", "root", "", "bdprovincias");
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$resultado = $mysqli->query("SELECT count(*) as num_provincias,com.nombre as nombre  FROM tbl_comunidadesautonomas as com, tbl_provincias as pro WHERE pro.comunidad_id=com.id GROUP BY com.id;");

while ($fila = $resultado->fetch_assoc()) {
    echo $fila['nombre'] . ": " . $fila['num_provincias'] . "<br>";
}
