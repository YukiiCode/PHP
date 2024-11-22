<?php

function once_noche()
{
    // H,m,s hasta las 11 de la noche
    // Fecha y hora actual
    $ahora = new DateTime();

    // 1. Calcular horas, minutos y segundos para las 11 de la noche
    $hora_objetivo = new DateTime('23:00:00');
    if ($ahora > $hora_objetivo) {
        // Si ya pasó las 11 de la noche, se refiere al siguiente día
        $hora_objetivo->modify('+1 day');
    }

    $intervalo = $ahora->diff($hora_objetivo);
    echo $intervalo->h . " horas, "
        . $intervalo->i . " minutos, "
        . $intervalo->s . " segundos\n hasta las 11 de la noche";
}

function tiempo_cambiar_hora()
{
    $ahora = new DateTime();
    $prox_cambio_hora = clone $ahora;
    $prox_cambio_hora->modify('+1 hour');
    $prox_cambio_hora->setTime($prox_cambio_hora->format('H'), 0, 0); // Establece minutos y segundos a 0
    $intervalo_cambio = $ahora->diff($prox_cambio_hora);
    echo "Próxima hora: " . ($intervalo_cambio->i) . " minutos, " . $intervalo_cambio->s . " segundos<br>";
}

function fecha_dentro_cinco_dias()
{
    $ahora = new DateTime();
    $fecha_futura = (clone $ahora)->modify('+5 days');
    echo "Fecha dentro de 5 días: " . $fecha_futura->format('Y-m-d') . "<br>";
}

function edad()
{
    $fecha_nacimiento = new DateTime('1982-03-21');
    $ahora = new DateTime();
    echo "Edad " . $fecha_nacimiento->diff($ahora)->y . "\n";
}
