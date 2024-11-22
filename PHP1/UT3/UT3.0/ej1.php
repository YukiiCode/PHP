<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Tabla del 5</h1>
    <table border="1px">
        <tr>
            <?php
            for ($i = 0; $i <= 10; $i++)
                echo "<tr><td>" ."5 <td>x</td> <td> $i</td> <td>= </td><td>" . 5 * $i . "</td> </tr>"
            ?>
        </tr>
    </table>
</body>

</html>