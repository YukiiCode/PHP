<?php

if ($_POST) {
    if ($_POST['op1'] && $_POST['op2'] && $_POST['operacion']) {
        $operador1 = $_POST['op1'];
        $operador2 = $_POST['op2'];
        $opSymbol = $_POST['operacion'];
        $_POST['op'] = opName($opSymbol);
        $_POST['result'] = calculate($operador1,$operador2,$opSymbol);
    }
}

function calculate($operador1, $operador2, $opSymbol)
{
    switch ($opSymbol) {
        case '+':
            return $operador1 + $operador2;
        case '-':
            return $operador1 - $operador2;
        case '*':
            return $operador1 * $operador2;
        case '/':
            if ($operador2 != 0) {
                return $operador1 / $operador2;
            } else {
                return "Error: División por 0";
            }
    }
}

function opName($opSymbol)
{
    switch ($opSymbol) {
        case '+':
            return 'Sumar';
        case '-':
            return 'Restar';
        case '*':
            return 'Multiplicar';
        case '/':
            return 'Dividir';
        default:
            return 'Error';
    }
}
