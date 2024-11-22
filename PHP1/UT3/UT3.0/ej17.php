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
    function MuestraFecha($dia, $mes, $anyo)
    {
        $date = mktime(0, 0, 0, $mes, $dia, $anyo);
        return date("l", $date) . " " . date("d", $date) . " de " . nom_mes($mes) . " de " . date("Y",$date);
    }
    echo MuestraFecha(10, 12, 2024);
    ?>
</body>

</html>