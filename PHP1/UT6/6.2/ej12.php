<?php

// [CONSULTA] 
$mysqli = new mysqli("localhost", "root", "", "bdprovincias");
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$tabla_com = "tbl_comunidadesautonomas";
$tabla_pro = "tbl_provincias";

// Incluimos los nombres de las tablas directamente en la consulta
$stmt = $mysqli->prepare("SELECT com.nombre AS comunidad, pro.nombre AS provincia 
                          FROM $tabla_com AS com 
                          JOIN $tabla_pro AS pro ON pro.comunidad_id = com.id 
                          ORDER BY com.nombre");

$stmt->execute();
$stmt->bind_result($comunidad, $provincia);

$array = [];
while ($stmt->fetch()) {
    $array[$comunidad][] = $provincia;
}

echo "<table border='1px'> <tr><td>CCAA</td><td>Provincias</td></tr>";
foreach ($array as $comunidad => $provincias) {
    echo "<tr><td rowspan='" . (count($provincias) + 1) . "'>$comunidad</td>";
    foreach ($provincias as $provincia) {
        echo "<tr><td>$provincia</td></tr>";
    }
    echo "</tr>";
}
echo "</table>";


// [INSERCIÓN] 

$stmt = $mysqli->prepare("INSERT INTO tbl_comunidadesautonomas (id, nombre) VALUES (?, ?)");
$stmt->bind_param("is", $id_comunidad, $nombre_comunidad);


$id_comunidad = 18; // Comunidad inventada
$nombre_comunidad = "Nueva Comunidad";
$stmt->execute();

// Inserción nueva provincia
$stmt = $mysqli->prepare("INSERT INTO tbl_provincias (id, nombre, comunidad_id) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $id_provincia, $nombre_provincia, $id_comunidad);


$id_provincia = 59; 
$nombre_provincia = "Nueva Provincia";
$stmt->execute();


// [Actualización] 

$stmt = $mysqli->prepare("UPDATE tbl_provincias SET nombre = ? WHERE id = ?");
$stmt->bind_param("si", $nuevo_nombre, $id_provincia);


$nuevo_nombre = "Provincia Actualizada";
$id_provincia = 59; //id de la provincia que queremos actualizar
$stmt->execute();

echo "Provincia actualizada correctamente.";

?>