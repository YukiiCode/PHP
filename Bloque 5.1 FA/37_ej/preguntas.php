<?php

$preguntas = [
    [
        'texto' => "Sexo: ",    // Texto para el formulario
        'tipo' => 'uno',        // uno/multi, uno para respuesta única
        'name_res' => 'sexo',   // para poner name en html luego
        'respuestas' => array(  // opciones para responder
            ['etiqueta' => 'Hombre', 'valor' => 'H'],
            ['etiqueta' => 'Mujer', 'valor' => 'M']
        )
    ],
    [
        'texto' => "Aficiones (múltiple)",
        'tipo' => 'multi',
        'name_res' => 'aficion',
        'respuestas' => array(
            ['etiqueta' => 'Deporte', 'valor' => 'deporte'],
            ['etiqueta' => 'Cine', 'valor' => 'cine'],
            ['etiqueta' => 'Teatro', 'valor' => 'teatro']
        )
    ],
    [
        'texto' => 'Estudios que tiene (múltiple)',
        'tipo' => 'multi',
        'name_res' => 'estudios',
        'respuestas' => array(
            ['etiqueta' => 'Eso', 'valor' => 'eso'],
            ['etiqueta' => 'C.F.G.Medio', 'valor' => 'cfgmed'],
            ['etiqueta' => 'C.F.G.Superior', 'valor' => 'cfgsup'],
            ['etiqueta' => 'Grado', 'valor' => 'grado']
        )
    ],
    [
        'texto' => 'Lugar al que le gustaria ir de vacaciones (una sola opción)',
        'tipo' => 'uno',
        'name_res' => 'l_vacaciones',
        'respuestas' => array(
            ['etiqueta' => 'Mediterráneo',  'valor' => 'mediterraneo'],
            ['etiqueta' => 'Caribe', 'valor' => 'caribe'],
            ['etiqueta' => 'EEUU', 'valor' => 'eeuu'],
            ['etiqueta' => 'Centro Europa', 'valor' => 'centroeuropa']
        )
    ]
];
$p_deporte = [
    'texto' => 'Deporte favorito',
    'tipo' => 'uno',
    'name_res' => 'deporte_fav',
    'respuestas' => array(
        ['etiqueta' => 'Fútbol', 'valor' => 'futbol'],
        ['etiqueta' => 'Baloncesto', 'valor' => 'baloncesto'],
        ['etiqueta' => 'Voleibol', 'valor' => 'voleibol'],
        ['etiqueta' => 'Tenis', 'valor' => 'tenis']
    )
];

$p_estudios_eso = [
    'texto' => 'Año de obtención de ESO',
    'tipo' => 'fecha',
    'name_res' => 'año_eso',
    'respuestas' => array()
];

$p_mediterraneo = [
    'texto' => 'Vacaciones en el Mediterráneo, ¿Destino?',
    'tipo' => 'uno',
    'name_res' => 'destino_mediterraneo',
    'respuestas' => array(
        ['etiqueta' => 'España', 'valor' => 'esp'],
        ['etiqueta' => 'Italia', 'valor' => 'ita'],
        ['etiqueta' => 'Grecia', 'valor' => 'gre'],
        ['etiqueta' => 'Turquía', 'valor' => 'tur']
    )
];

$preguntasAdicionales = [
    'deporte' => $p_deporte,
    'estudios_eso' => $p_estudios_eso,
    'mediterraneo' => $p_mediterraneo
];
