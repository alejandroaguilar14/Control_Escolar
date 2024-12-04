@extends("components.layout")

@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent

<style>
    .card-header {
        background-color: #343a40;
        color: white;
        text-align: center;
    }

    .input-label {
        color: #343a40;
    }

    .input-style {
        border: 2px solid #6c757d;
        padding: 10px;
        width: 100%; /* Hacer que el input ocupe todo el ancho */
    }

    .input-style:focus {
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

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: 2px solid #6c757d;
        padding: 0.5rem;
        width: 100%;
    }

    .center-form {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
    }

    .container {
        max-width: 800px;
    }

    .card {
        width: 100%;
    }
</style>

<!-- Formulario para modificar la fecha de participación de un profesor en un examen práctico -->
<div class="center-form">
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white">
                <!-- Título del formulario -->
                <h1 class="mb-0">
                    Modificar Fecha de Participación
                </h1>
            </div>
            <div class="card-body">
                <!-- Inicio del formulario -->
                <form method="post" action="@if(isset($profesor)){{ url('/catalogos/examenpractico/' . $detalle->id_det_prof_examPractico . '/profesores/modificar') }}@else{{ url('/catalogos/alumnos/agregar') }}@endif">
                    @csrf
                    <!-- Fila para mostrar el nombre completo del profesor -->
                    <div class="row my-3">
                        <h3 class="text-center">Profesor: {{$profesor->nombre}} {{$profesor->primerApellido}} {{$profesor->segundoApellido}}</h3>
                    </div>
                    <!-- Fila para seleccionar o mostrar la fecha de participación -->
                    <div class="row my-2">
                        <label for="fechaParticipacion">Fecha:</label>
                        <input type="date" name="fechaParticipacion" id="fechaParticipacion" class="form-control" value="{{ $detalle->fechaParticipacion ?? '' }}">
                    </div>
                    <!-- Fila para botones de acción -->
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <!-- Botón para guardar los cambios -->
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <!-- Botón para regresar al listado de profesores en el examen práctico -->
                            <a href='{{ url("/catalogos/examenpractico/$detalle->fk_idExamenPractico/profesores") }}' class="btn btn-dark">Regresar</a>
                        </div>
                    </div>
                </form>
                <!-- Fin del formulario -->
            </div>
        </div>
    </div>
</div>


@endsection
