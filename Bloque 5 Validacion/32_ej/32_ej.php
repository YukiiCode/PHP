<?php

$errores = [];

if ($_POST) {
    if (empty($_POST['name']))
        $errores['name'] = "Campo Nombre vacío";
    if (empty($_POST['lname']))
        $errores['lname'] = "Campo Apellidos vacío";
    if (!isset($_POST['sexo']))
        $errores['sexo'] = "Campo sexo vacío";
    if (empty($_POST['curso']))
        $errores['curso'] = "Campo curso vacío";
    if (empty($_POST['bdate']))
        $errores['bdate'] = "Campo fecha nacimiento vacío";

    if ($errores)
        foreach ($errores as $campo => $mensaje)
            echo $mensaje . "<br>";
    else {
        echo "<table border='1px solid black'><tr>";
        echo "<td>" . $_POST['name'] . "</td>";
        echo "<td>" . $_POST['lname'] . "</td>";
        echo "<td>" . $_POST['sexo'] . "</td>";
        echo "<td>" . $_POST['curso'] . "</td>";    
        echo "<td>" . $_POST['bdate'] . "</td>";
        echo "<td>" . nl2br($_POST['observaciones']) . "</td>";
    }
}
