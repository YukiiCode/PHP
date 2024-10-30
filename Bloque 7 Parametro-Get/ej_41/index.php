<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <table border="1px solid black">
        <tr>
            <td><a href="pagina2.php?Nombre=<?= urlencode('Juan') ?>&Apellidos=<?= urlencode('López') ?>&Edad=33">Juan</a></td>
        </tr>
        <tr>
            <td><a href="pagina2.php?Nombre=<?= urlencode('Marisa') ?>&Apellidos=<?= urlencode('Carrasco') ?>&Edad=24">Marisa</a></td>
        </tr>
    </table>

</body>

</html>