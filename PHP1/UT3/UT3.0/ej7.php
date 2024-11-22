<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    do {
        $num = rand(1, 100);
        echo $num."<br>";
    } while ($num != 15);

    ?>
</body>

</html>