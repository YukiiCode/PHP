<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    echo date('Y-m-d H:i:s', time() + 50) . "<br>";
    $timestamp = mktime(
        date("H") + 2,
        date("i") + 4,
        date("s") + 3,
        date("m"),
        date("d"),
        date("Y")
    );

    echo date("Y-m-d H:i:s", $timestamp);
    ?>
</body>

</html>