@extends("components.layout")
@section("content")

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
        color: #fff;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    h5 {
        color: #343a40;
    }

    h1 {
        color: white;
    }

    .form-check-input {
        margin-right: 10px;
    }

    .examen-title, .grupo-name {
        font-size: 1.50rem; /* Aumenta el tamaño del texto */
        font-weight: bold; /* Opcional: para hacerlo más destacado */
    }
</style>

<div class="container mt-5">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0">Editar Evaluación</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/movimientos/evaluaciones/' . $evaluacion->idEvaluacion . '/modificar/') }}">
                        @csrf
                        <div class="row my-2">
                            <div class="form-group">
                                <h5>Nombre del Examen:</h5>
                                <p class="examen-title">{{ $examenTitulo }}</p>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="form-group">
                                <h5>Grupo:</h5>
                                <p class="grupo-name">{{ $evaluacion->grupo->nombre }}</p>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha de Evaluación:</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $evaluacion->fecha }}" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">
                                <br>
                                <button type="submit" class="btn btn-primary">Actualizar Evaluación</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection