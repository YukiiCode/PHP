<?php

namespace App\Http\Controllers;

function filtrar($campo, $expresionRegular, &$errores)
{
    if (empty($_POST[$campo])) {
        $errores[$campo] = "Campo '$campo' vacío";
    } else if ($expresionRegular && !preg_match($expresionRegular, $_POST[$campo]))
        $errores[$campo] = "Campo '$campo' inválido<br>";
}

function validarFormulario()
{
    $errores = []; // Inicializar errores

    // NIF/CIF
    filtrar('nif_cif', "/^([0-9]{8}[A-Z]|[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J])$/", $errores);

    // Nombre
    filtrar('nombre', "/^[a-zA-Z]+$/", $errores);

    // Apellidos
    filtrar('apellidos', "/^[a-zA-Z]+$/", $errores);

    // Teléfono
    filtrar('telefono', "/^\+\d{1,3}[-\s]?\d{1,4}([-\s]?\d{3,4}){2,3}$/", $errores);

    // Descripción
    filtrar('descripcion', "/^[a-zA-Z]+$/", $errores);

    // Email
    filtrar('email', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $errores);

    // Dirección
    filtrar('direccion', null, $errores);

    // Población
    filtrar('poblacion', null, $errores);

    // Código postal
    filtrar('codigo_postal', "/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/", $errores);

    // Provincia (select)
    filtrar('provincia', null, $errores);

    // Operario (select)
    filtrar('operario', null, $errores);

    // Fecha realización
    filtrar('fecha_realizacion', "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/", $errores);

    // Anotaciones posteriores
    filtrar('anotaciones_posteriores', null, $errores);

    // Estado
    $_POST['estado'] = "B"; // [Provisional] Automático: Esperando a ser aprobada

    return $errores;
}
