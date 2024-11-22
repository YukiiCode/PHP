<?php

if ($_GET) {
    echo "Datos del seleccionado<br>";
    echo "Nombre: " . $_GET['Nombre'] . " " . $_GET['Apellidos'] . "<br>";
    echo "Edad: " . $_GET['Edad'];
}

?>