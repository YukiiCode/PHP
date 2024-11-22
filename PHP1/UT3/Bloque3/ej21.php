<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $car1 = ["matricula" => "2123RTH", "color" => "Blanco", "modelo" => "Corsa", "marca" => "Opel"];
    $car2 = ["matricula" => "4376KTM", "color" => "Negro", "modelo" => "Megane", "marca" => "Renault"];
    $car3 = ["matricula" => "2426IOH", "color" => "Rosa", "modelo" => "Corsa", "marca" => "Opel"];
    $car4 = ["matricula" => "8776FJM", "color" => "Azul", "modelo" => "Megane", "marca" => "Renault"];
    $car5 = ["matricula" => "2623LNP", "color" => "Blanco", "modelo" => "Corsa", "marca" => "Opel"];

    $cars = [$car1, $car2, $car3, $car4, $car5];

    function muestraCoche($car)
    {
        return $car['matricula'] . " " . $car['color'] . " " . $car['modelo'] . " " . $car['marca'];
    }

    function muestraCoches($cars)
    {
        foreach ($cars as $car) {
            echo muestraCoche($car) . "<br>";
        }
    }

    echo muestraCoches($cars);
    $cars[] = ["matricula" => "2654VTE", "color" => "Amarillo", "modelo" => "Supra", "marca" => "Toyota"];
    $cars[] = ["matricula" => "7654GTB", "color" => "Rojo", "modelo" => "MX5", "marca" => "Mazda"];

    echo muestraCoches($cars);

    ?>
</body>

</html>