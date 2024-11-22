<?php

function tablaMultiplicar($num)
{
    echo "<table>";
    echo "<tr>";
    for ($i = 0; $i < 11; $i++)
        echo $num * $i;
    echo "<tr>";
}

?>