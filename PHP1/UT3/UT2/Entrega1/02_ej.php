<!-- 
2. Crea un nuevo script en en php en el que inicializaras distintas variables con diferentes
tipos de datos y luego mostrarás sus valores.
◦ Variables de tipo entero: expresa el número en decimal, octal, hexadecimal
◦ Variable de tipo float: expresa el número con punto, en notación flotante, etc.
◦ Variable de tipo cadena
◦ Variable tipo booleano
-->

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

    ?>

</body>

</html>