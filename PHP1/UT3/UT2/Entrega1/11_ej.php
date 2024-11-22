<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $a = 1;
    $b = "1";

    if (1 == "1")
        echo "igualdad simple";
    if (1 === "1")
        echo "Igualdad estricta";

    // 1 es  == a "1" pero no con === que es igualdad estricta,
    // ya que comprueba el tipo de la variable

    ?>
</body>

</html>