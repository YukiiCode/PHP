<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function DiasMes($num_mes)
    {
        $dias_mes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $nom_mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        return $dias_mes[$num_mes];
    }
    echo DiasMes(2);
    ?>
</body>

</html>