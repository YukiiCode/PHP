<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function esPrimo($num)
    {
        for ($i = 2; $i < $num - 1; $i++)
            return ($num % $i == 0) ? false : true;
    }

    for ($i = 0, $count = 0; $count < 100; $i++)
        if (esPrimo($i)) {
            $count++;
            echo "Es primo: " . $i . "<br>";
        }
    ?>

</body>

</html>