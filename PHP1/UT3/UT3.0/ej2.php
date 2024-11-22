<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1></h1>
    <table border="1px" style="border-collapse: collapse;">
        <tr>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>";
                echo  "<td colspan='5'>Tabla del $i</td>";
                for ($y = 0; $y <= 10; $y++)
                    echo "<tr><td>$i<td>x<td>$y<td>=</td><td>" . $i * $y . "</td>";
                echo "</tr>";
            }


            ?>
        </tr>
    </table>
</body>

</html>