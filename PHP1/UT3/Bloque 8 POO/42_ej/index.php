<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include("./script.php");
    echo once_noche() . "<br>";
    echo tiempo_cambiar_hora();
    echo fecha_dentro_cinco_dias();
    echo edad();
    ?>
</body>

</html>