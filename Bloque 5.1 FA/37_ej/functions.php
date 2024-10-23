<?php

function getHTMLPregunta($preguntas)
{
    echo "<form action='./index.php' method='post'>";
    foreach ($preguntas as $pregunta) {
        echo "<div>" . $pregunta['texto'] . buildRespuestas($pregunta) . "</div>";
    }
    echo "<button type='submit' value='Enviar'>Enviar</button>";
    echo "</form>";
}

function buildRespuestas($pregunta)
{
    $string = "<br>";
    // El ternario es simple, si es 'uno' es radio, 'multi' es checkbox y else es date
    $tipo = $pregunta['tipo'] == 'uno' ? "radio" : ($pregunta['tipo'] == 'multi' ? "checkbox" : "date");

    foreach ($pregunta['respuestas'] as $respuesta) {
        if ($tipo == 'date')
            $string .= "<input type='$tipo'" . $pregunta['name_res'] . '><br>';
        else
            $string .= "<input type='$tipo' name='" . $pregunta['name_res'] . "' value='" . $respuesta['valor'] . "'> " . $respuesta['etiqueta'] . "<br>";
    }
    return $string;
}

function preguntasAdicionales($preguntasAdicionales)
{
    $stringAdicional = "<br>";
    if ($_POST) {
        echo "<form action='./index.php' method='post'>";
        if ($_POST['aficion'] == 'deporte')
            $stringAdicional .= buildRespuestas($preguntasAdicionales['deporte']);
        if ($_POST['estudios'] == 'eso')
            $stringAdicional .= buildRespuestas($preguntasAdicionales['estudios_eso']);
        if ($_POST['l_vacaciones'] == 'mediterraneo')
            $stringAdicional .=  buildRespuestas($preguntasAdicionales['mediterraneo']);
        echo $stringAdicional;
        echo "<button type='submit' value='Enviar'>Enviar</button>";
        echo "</form>";
    }
}
