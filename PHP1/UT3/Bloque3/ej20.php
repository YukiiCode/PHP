<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function numMax()
    {
        $numbers = [4, 3, 6, 8, 1, 9, 2];
        arsort($numbers);
        $numbers = array_values($numbers);
        echo $numbers[0];
    }
    numMax();
    ?>
</body>

</html>