<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function intercambia($v1, $v2)
    {
        echo "Valor inicial de v1: $v1, v2: $v2 <br>";
        $aux = $v1;
        $v1 = $v2;
        $v2 = $aux;
        echo "Valor actual de v1: $v1, v2: $v2 <br>";
    }
    intercambia(3, 5);
    ?>
</body>

</html>