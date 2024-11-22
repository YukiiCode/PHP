<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    for ($i = 1; $i < 1000; $i++) {
        if ($i % 3 == 0 || $i % 5 == 0 || $i % 7 == 0) {
            echo ($i . " ");
            if ($i % 10 == 0)
                echo "<br>";
        }
    }

    ?>
</body>

</html>