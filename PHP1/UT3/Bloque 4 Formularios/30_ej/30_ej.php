<?php

if ($_POST) {
    echo "<table border='1px solid black'><tr>";
    echo "<td>" . $_POST['name'] . "</td>";
    echo "<td>" . $_POST['lname'] . "</td>";
    echo "<td>" . $_POST['sexo'] . "</td>";
    echo "<td>" . $_POST['curso'] . "</td>";
    echo "<td>" . $_POST['bdate'] . "</td>";
} else echo "Error";
