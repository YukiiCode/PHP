<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $dia = rand(1, 10);
    switch ($dia) {
        case 1:
            echo "Uno";
            break;
        case 2:
            echo "Dos";
            break;
        case 3:
            echo "Tres";
            break;
        case 4:
            echo "Cuatro";
            break;
        case 5:
            echo "Cinco";
            break;
        case 6:
            echo "Seis";
            break;
        case 7:
            echo "Siete";
            break;
        case 8:
            echo "Ocho";
            break;
        case 9:
            echo "Nueve";
            break;
        case 10:
            echo "Diez";
            break;
    }
    ?>

</body>

</html>