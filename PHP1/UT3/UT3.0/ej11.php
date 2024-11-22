<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function diaMes($num_mes)
    {
        switch ($num_mes) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;
            case 2:
                return 28;
            default:
                return 30;
        }
    }

    function nom_mes($num_mes)
    {
        switch ($num_mes) {
            case 1:
                return "Enero";
            case 2:
                return "Febrero";
            case 3:
                return "Marzo";
            case 4:
                return "Abril";
            case 5:
                return "Mayo";
            case 6:
                return "Junio";
            case 7:
                return "Julio";
            case 8:
                return "Agosto";
            case 9:
                return "Septiembre";
            case 10:
                return "Octubre";
            case 11:
                return "Noviembre";
            case 12:
                return "Diciembre";
            default:
                return "Mes inválido";
        }
    }

    for ($year = 1999; $year < 2013; $year++)
        for ($num_mes = 1; $num_mes < 13; $num_mes++) {
            $dias = diaMes($num_mes);
            if ($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0) && $num_mes == 2)
                $dias += 1;
            echo "Año:$year Mes: " . nom_mes($num_mes) . " Dias:$dias<br>";
        }

    ?>

</body>

</html>