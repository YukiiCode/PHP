<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function comprobarDni($dni)
    {
        $letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
        $dni_array = str_split($dni);
        if (count($dni_array) == 9) {
            for ($i = 0; $i < 8; $i++) {
                $dni_array[$i] = (int) $dni_array[$i];
                if (!is_numeric($dni_array[$i]))
                    return false;
            }
            $sum = 1;
            foreach ($dni_array as $num)
                $sum = $sum + (int) $num;
            return ($letras[$sum % 23] == $dni_array[8]) ? true : false;
        }
    }
    if (comprobarDni("49399939X"))
        echo "correcto <br>";
    else echo "no correcto<br>";
    if (comprobarDni("49375751V"))
        echo "correcto<br>";
    else echo "no correcto<br>";
    ?>
</body>

</html>