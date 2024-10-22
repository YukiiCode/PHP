<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        label {
            display: flex;
            padding: 7px;
        }
    </style>
    <?php include("35_ej.php") ?>
</head>

<body>
    <h1>Calculadora</h1>
    <form action="index.php" method="post">
        <label for="op1">Operador 1:
            <input type="text" name="op1" value="<?php echo isset($_POST['op1']) ? $_POST['op1'] : ''; ?>">
        </label>
        <label for="op2">Operador 2:
            <input type="text" name="op2" value="<?php echo isset($_POST['op2']) ? $_POST['op2'] : ''; ?>">
        </label>
        <label>Operación:
            <input type="text" name="op" readonly value="<?php echo isset($_POST['op']) ? $_POST['op'] : ''; ?>">
        </label>
        <label>Resultado:
            <input type="text" name="result" readonly value="<?php echo isset($_POST['result']) ? $_POST['result'] : ''; ?>">
        </label>

        <p>Seleccione operación: </p>
        <input type="radio" name="operacion" value="+" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == '+') ? 'checked' : ''; ?>> Sumar
        <input type="radio" name="operacion" value="-" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == '-') ? 'checked' : ''; ?>> Restar
        <input type="radio" name="operacion" value="*" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == '*') ? 'checked' : ''; ?>> Multiplicar
        <input type="radio" name="operacion" value="/" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == '/') ? 'checked' : ''; ?>> Dividir
        <p></p>
        <input type="submit" value="Calcular">
    </form>
</body>

</html>