<!--
1. Realiza una página web que muestre información sobre el interprete php que tienes
funcionando (versión y librerías). Busca en la ayuda (php.net) lo que hace la función
phpinfo()
Identifica:
• Versión de PHP
• Servidor web que estás utilizando
• Comprueba si alguna de las opciones que tienes configuradas en el fichero php.ini
se corresponden con la información mostrada en la sección “Core”. Busca por el
nombre “Directive”
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>01_Ejercicio.php</title>
</head>
<body>

<?php

echo "Versión php: " . phpversion() ."<br>";
echo "Servidor web: Apache 2.0<br>";
echo "Configuración fichero php.ini: Predeterminada, el fichero está vacío, las configuraciones aplicadas estan en el apartado core del phpinfo()";
echo phpinfo();


?>
    
</body>
</html>

