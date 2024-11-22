<?php

function getHTMLPregunta($preguntas)
{
    echo "<form action='' method='post'>";
    foreach ($preguntas as $pregunta) {
        echo "<div>" . $pregunta['texto'] . buildRespuestas($pregunta) . "</div>";
    }
    echo "<button type='submit' value='Enviar'>Enviar";
    echo "</form>";
}

function buildRespuestas($pregunta)
{
    $string = "<br>";
    $tipo = $pregunta['tipo'] == 'uno' ? "radio" : "checkbox";

    foreach ($pregunta['respuestas'] as $respuesta) {
        $string .= "<input type='$tipo' name='" . $pregunta['name_res'] . "' value='" . $respuesta['valor'] . "'> " . $respuesta['etiqueta'] . "<br>";
    }
    return $string;
}