<?php

if ($_GET) {
    echo "Nombre: " . strtoupper($_GET["nombre"] . "<br>");
    echo "Apellidos: " . strtoupper($_GET["apell"]);
}
