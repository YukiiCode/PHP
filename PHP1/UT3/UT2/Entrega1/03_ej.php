<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>02_Ejercicio.php</title>
</head>

<body>
    <h1>Tipos de datos</h1>
    <?php
    $decimal = 42; // Número en decimal
    $octal = 052; // Número en octal
    $hexadecimal = 0x2A; // Número en hexadecimal 

    $float = 3.1416; // Número con punto decimal
    $scientific = 2.5e3; // Notación científica

    $string = "¡Hola, mundo!";

    // booleano
    $booleanTrue = true;
    $booleanFalse = false;

    echo $decimal . ": " . gettype($decimal) . "<br>";
    echo $octal . ": " . gettype($octal) . "<br>";
    echo $hexadecimal . ": " . gettype($hexadecimal) . "<br>";
    echo $float . ": " . gettype($float) . "<br>";
    echo $scientific . ": " . gettype($scientific) . "<br>";
    echo $string . ": " . gettype($string) . "<br>";
    echo $booleanTrue . ": " . gettype($booleanTrue) . "<br>";
    echo $booleanFalse . ": " . gettype($booleanFalse) . "<br>";

    ?>

</body>

</html>