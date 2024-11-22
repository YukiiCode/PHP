<?php
session_start();


function incrementar()
{
    // Inicializamos la sesión si no existe
    if (!isset($_SESSION['num'])) {
        $_SESSION['num'] = 0;
    }
    // El valor de la sesion se igual al del input por si el usuario
    // a cambiado el valor
    else $_SESSION['num'] = $_POST['num'];

    // Si el botón [+1] fue presionado, incrementa el valor
    if (isset($_POST['+1'])) {
        $_SESSION['num'] += 1;
    }
}

// Llamamos a la función si es necesario
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
        <input type="text" name="num" id="" value="<?php echo $_SESSION['num']; ?>">
        <!-- Botón para incrementar el número -->
        <button type="submit" name="+1">+1</button>
    </form>
</body>

</html>