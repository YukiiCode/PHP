@extends('plantilla')

@section('titulo', 'Ayuda')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Página de Ayuda</h2>
    <div class="card">
        <div class="card-header">
            <h4>Preguntas Frecuentes</h4>
        </div>
        <div class="card-body">
            <h5>¿Cómo puedo crear una nueva tarea?</h5>
            <p>Para crear una nueva tarea, ve a la sección "Nueva Tarea" en el menú principal y completa el formulario
                con la información requerida.</p>

            <h5>¿Cómo puedo editar una tarea existente?</h5>
            <p>Para editar una tarea existente, ve a la sección "Ver Tareas", selecciona la tarea que deseas editar y
                haz clic en el botón "Editar".</p>

            <h5>¿Cómo puedo eliminar una tarea?</h5>
            <p>Para eliminar una tarea, ve a la sección "Ver Tareas", selecciona la tarea que deseas eliminar y haz clic
                en el botón "Eliminar". Se te pedirá que confirmes la eliminación.</p>

            <h5>¿Cómo puedo cambiar mi contraseña?</h5>
            <p>Para cambiar tu contraseña, ve a la sección "Perfil" en el menú principal y selecciona "Cambiar
                Contraseña".</p>
        </div>
    </div>
</div>
@endsection