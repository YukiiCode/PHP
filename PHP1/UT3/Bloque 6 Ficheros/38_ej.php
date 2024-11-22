<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Subir archivo</h2>
    <form action="38_ej.php" method="post" enctype="multipart/form-data">
        Selecciona un archivo:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br><br>
        <input type="submit" value="Subir archivo" name="submit">
    </form>
    <?php
    // Comprobar si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Carpeta donde se guardará el archivo
        $target_dir = __DIR__ . '/';  // Guardar en la misma carpeta que el script
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);  // Ruta final del archivo
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // Obtener la extensión del archivo

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            echo "Lo siento, el archivo ya existe.";
            $uploadOk = 0;
        }

        // Comprobar si hubo algún error en la subida
        if ($_FILES["fileToUpload"]["error"] != 0) {
            echo "Hubo un error al subir el archivo.";
            $uploadOk = 0;
        }

        // Si no hubo errores, intentamos subir el archivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "El archivo " . basename($_FILES["fileToUpload"]["name"]) . " ha sido subido correctamente.";
                // Generar un enlace para descargar el archivo subido
                echo "<a href='" . basename($target_file) . "' download>Descargar archivo</a>";
            } else {
                echo "Hubo un problema al mover el archivo.";
            }
        }
    } else {
        echo "No se ha recibido ningún archivo.";
    }
    ?>

</body>

</html>