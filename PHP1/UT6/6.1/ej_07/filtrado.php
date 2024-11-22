<?php

$errores = [];

if ($_POST) {
    $mysqli = new mysqli("localhost", "root", "", "bdprovincias");
    $mysqli->set_charset('utf8');

    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    if (empty($_POST['provincia']))
        $errores[] = "Campo Provincia vacío";

    $nombreProvincia = $_POST['provincia'];
    $consulta_pro = $mysqli->prepare("SELECT * FROM tbl_provincias WHERE ?");
    $consulta_pro->bind_param("s", $nombreProvincia);
    $consulta_pro->execute();
    $consulta_pro->store_result();

    if ($consulta_pro->num_rows > 0) {
        $errores[] = "Esta provincia ya existe";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $nombreProvincia))
        $errores[] = "Caracteres inválidos";

    if ($errores)
        foreach ($errores as $campo => $mensaje)
            echo $mensaje . "<br>";
    else {
        $nombreComunidad = "Nuevas provincias";

        // Verificar y crear la comunidad "Nuevas provincias" si no existe
        $consultaCom = $mysqli->query("SELECT id FROM tbl_comunidadesautonomas WHERE nombre = '$nombreComunidad'");
        if ($consultaCom->num_rows === 0) {
            $mysqli->query("INSERT INTO tbl_comunidadesautonomas (nombre) VALUES ('$nombreComunidad')");
            $idComunidad = $mysqli->insert_id; // Obtener el ID de la nueva comunidad
        } else {
            $comunidad = $consultaCom->fetch_assoc();
            $idComunidad = $comunidad['id']; // Recuperar el ID de la comunidad existente
        }

        $consulta_com = $insert_pro = $mysqli->prepare("INSERT INTO tbl_provincias (nombre, comunidad_id) VALUES (?, ?)");;
        $insert_pro = $mysqli->prepare("INSERT INTO tbl_provincias (nombre, comunidad_id) VALUES (?, ?)");
        $insert_pro->bind_param("si", $nombreProvincia, $idComunidad);
        $insert_pro->execute();
    }
}

?>