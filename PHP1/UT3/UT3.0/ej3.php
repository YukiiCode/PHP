<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <tr>
        <?php
        $num = rand(1, 10);
        echo "<h1>Tabla del $num</h1>";
        echo "<table border='1px'> <tr>";
        for ($i = 0; $i <= 10; $i++)
            echo "<tr><td>" . "$num <td>x</td> <td> $i</td> <td>= </td><td>" . $num * $i . "</td> </tr>";
        echo "</tr>";
        ?>
    </tr>
    </table>
</body>

</html>