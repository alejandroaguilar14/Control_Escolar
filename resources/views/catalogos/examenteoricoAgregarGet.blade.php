@extends("components.layout")
@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: 2px solid #6c757d;
        padding: 5px;
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0 text-center">Agregar Examen Teórico</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/catalogos/examenteorico/agregar') }}">
                        @csrf
                        <!-- Token CSRF para seguridad en formularios -->
                        
                        <!-- Campo para seleccionar el profesor -->
                        <div class="row my-2">
                            <div class="form-group">
                                <label for="idProf" class="input-label">Profesor:</label>
                                <select type="select" name="idProf" id="idProf" class="form-control input-style" required autofocus>
                                    <option value="">Selecciona a un profesor</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->idProfesor }}">{{ $profesor->nombreCompleto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Campo para el título del examen teórico -->
                        <div class="row my-2">
                            <div class="form-group">
                                <label for="titulo" class="input-label">Título:</label>
                                <input type="text" maxlength="50" name="titulo" id="titulo" placeholder="Ingrese el título del examen teórico" class="form-control input-style" required autofocus>
                            </div>
                        </div>
                        
                        <!-- Campo para la fecha del examen teórico -->
                        <div class="row my-2">
                            <div class="form-group mb-3 col-4">
                                <label for="fecha" class="input-label">Fecha:</label>
                                <input type="date" class="form-control input-style" id="fecha" name="fecha">
                            </div>
                        </div>
                        
                        <!-- Campo para el número de preguntas del examen teórico -->
                        <div class="row my-2">
                            <div class="form-group">
                                <label for="numPreguntas" class="input-label">Número de preguntas:</label>
                                <input type="number" min="1" max="100" name="numPreguntas" id="numPreguntas" placeholder="Ingrese el número de preguntas del examen teórico" class="form-control input-style" required autofocus>
                            </div>
                        </div>
                        
                        <!-- Botones para guardar y regresar -->
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ url('/catalogos/examenteorico') }}" class="btn btn-dark">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Fin de la sección "content" -->