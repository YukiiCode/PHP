<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        label {
            display: flex;
        }

        div {

            margin-bottom: 10px;
        }
    </style>
    <?php
    include("./functions.php");
    include("./preguntas.php")
    ?>
</head>

<body>
    <?php
    getHTMLPregunta($preguntas);
    ?>
</body>

</html>