<?php

if ($_POST) {
    $num = $_POST['num'];
    echo "Tabla del $num <br>";
    for ($y = 0; $y <= 10; $y++)
        echo $num . "x$y = " . $num * $y ."<br>";
}

?>