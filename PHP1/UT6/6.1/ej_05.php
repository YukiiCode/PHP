<?php

$mysqli = new mysqli("localhost", "root", "", "bdprovincias");
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$resultado = $mysqli->query("SELECT com.nombre AS comunidad, pro.nombre AS provincia 
                             FROM tbl_comunidadesautonomas AS com 
                             JOIN tbl_provincias AS pro ON pro.comunidad_id = com.id 
                             ORDER BY com.nombre");

while ($fila = $resultado->fetch_assoc()) {
    $array[$fila['comunidad']][] = $fila['provincia'];
}
?>
<table border='1px'>
    <tr>
        <td>CCAA</td>
        <td>Provincias</td>
    </tr>
    <?php
    foreach ($array as $comunidad => $provincias) {
        echo "<tr><td rowspan='" . count($provincias) + 1 . "'>$comunidad</td>";
        foreach ($provincias as $provincia) {
            echo "<tr><td> $provincia </td></tr>";
        }
        echo "</tr>";
    }
    ?>
</table>