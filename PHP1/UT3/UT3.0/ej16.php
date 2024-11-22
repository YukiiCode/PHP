<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'funciones_fecha.php';
    $num_mes = date("m");
    $mes = nom_mes($num_mes);
    echo $mes;

    ?>
</body>

</html>