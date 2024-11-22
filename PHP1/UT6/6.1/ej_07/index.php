<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="post">
        <div>Provincia:<input type="text" name="provincia" id=""></div>
        <button>Añadir</button>
        <a href="mostrar_provincias.php">Mostrar provincias</a>
    </form>
</body>

<?php
include('filtrado.php')
?>

</html>