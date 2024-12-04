@extends('components.layout')
<!-- Extiende la plantilla base 'layout' ubicada en la carpeta 'components' -->

@section('content')
<!-- Define la sección 'content' que será insertada en la plantilla base -->

@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
<!-- Incluye el componente de 'breadcrumbs' (migas de pan) y le pasa la variable $breadcrumbs -->

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: 2px solid #6c757d;
        padding: 10px;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 10px #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    h1 {
        color: white;
    }
</style>
<!-- Estilos personalizados para la vista -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0 text-center">Modificar datos del examen teórico</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/catalogos/examenteorico/' . $examenteorico->idExamenTeorico . '/modificar') }}">
                        @csrf
                        <input type="hidden" class="form-control input-style" id="fk_idProfesor" name="fk_idProfesor" value="{{ $examenteorico->fk_idProfesor }}" readonly>
                        <!-- Campo oculto para el ID del profesor asociado al examen -->

                        <div class="row my-2">
                            <div class="form-group">
                                <label for="fk_idProfesor" class="input-label">Nombre del Profesor:</label>
                                <p class="form-control-static input-style">
                                    @foreach($profesores as $profesor)
                                        @if($profesor->idProfesor == $examenteorico->fk_idProfesor)
                                            {{ $profesor->nombreCompleto }}
                                        @endif
                                    @endforeach
                                </p>
                                <!-- Muestra el nombre del profesor asociado al examen -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="titulo" class="input-label">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control input-style" value="{{ $examenteorico->titulo }}" autofocus>
                            <!-- Campo para modificar el título del examen -->
                        </div>

                        <div class="row my-2">
                            <div class="form-group mb-3 col-4">
                                <label for="fecha" class="input-label">Fecha:</label>
                                <input type="date" name="fecha" id="fecha" class="form-control input-style" value="{{ $examenteorico->fecha }}">
                                <!-- Campo para modificar la fecha del examen -->
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="form-group col-4">
                                <label for="numPreguntas" class="input-label">Número preguntas:</label>
                                <input type="number" min="1" max="100" name="numPreguntas" id="numPreguntas" class="form-control input-style" value="{{ $examenteorico->numPreguntas }}" autofocus>
                                <!-- Campo para modificar el número de preguntas del examen -->
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href='{{ url("/catalogos/examenteorico") }}' class="btn btn-dark">Regresar</a>
                                <!-- Botones para guardar los cambios y regresar a la lista de exámenes -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Fin de la sección 'content' -->
