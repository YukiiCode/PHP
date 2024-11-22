<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $time = time();
    $time2 = time() + 1;
    for ($i = 0; $time2 > $time; $i++) {
        if ($i % 5 == 0)
            echo $i . "<br>";
        $time = time();
    }
    ?>
</body>

</html>