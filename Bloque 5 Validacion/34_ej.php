<?php
session_start();

// Función que incrementa el valor
function incrementar()
{
    // Inicializamos la sesión si no existe
    if (!isset($_SESSION['num'])) {
        $_SESSION['num'] = 0;
    }

    // Si el botón [+1] fue presionado, incrementa el valor
    if (isset($_POST['+1'])) {
        $_SESSION['num'] += 1;
    }
}

// Llamamos a la función para incrementar si es necesario
incrementar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incrementar Número</title>
</head>

<body>
    <form action="" method="post">
        <!-- Mostramos el valor actual almacenado en la sesión -->
        <p name="num"><?php echo $_SESSION['num']; ?></p>
        <!-- Botón para incrementar el número -->
        <button type="submit" name="+1">+1</button>
    </form>
</body>

</html>