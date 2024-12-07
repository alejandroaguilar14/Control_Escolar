@extends("components.layout")
@section("content")

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
</style>

<div class="container mt-5">
    <!-- Mensaje de error si existe -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0">Agregar Evaluación</h1>
                </div>
                <div class="card-body">
                    <!-- Formulario para agregar evaluación -->
                    <form method="post" action="{{url('/movimientos/evaluaciones/agregar')}}">
                        @csrf
                        <div class="row my-2">
                            <div class="form-group">
                                <h5>Tipo de Examen:</h5>
                                <div class="row">
                                    <!-- Opción de examen teórico -->
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoExamen" value="TEORICO" id="checkTeorico" onchange="toggleCombobox('comboboxTeorico', 'comboboxPractico')">
                                            <label class="form-check-label" for="checkTeorico">Examen Teórico</label>
                                        </div>
                                        <div class="form-group">
                                            <!-- Selección de examen teórico -->
                                            <select class="form-control" id="comboboxTeorico" name="idExamen" disabled>
                                                <option value="">Selecciona examen teórico</option>
                                                @foreach($examenesTeoricos as $examenTeorico)
                                                    <option value="{{ $examenTeorico->idExamenTeorico }}">{{ $examenTeorico->titulo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Opción de examen práctico -->
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoExamen" value="PRACTICO" id="checkPractico" onchange="toggleCombobox('comboboxPractico', 'comboboxTeorico')">
                                            <label class="form-check-label" for="checkPractico">Examen Práctico</label>
                                        </div>
                                        <div class="form-group">
                                            <!-- Selección de examen práctico -->
                                            <select class="form-control" id="comboboxPractico" name="idExamen" disabled>
                                                <option value="">Selecciona examen práctico</option>
                                                @foreach($examenesPracticos as $examenPractico)
                                                    <option value="{{ $examenPractico->idExamenPractico }}">{{ $examenPractico->titulo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selección del grupo -->
                        <div class="row my-2">
                            <div class="form-group">
                                <h5>Selecciona el Grupo:</h5>
                                <div class="form-group">
                                    <select class="form-control" id="grupo" name="grupo">
                                        <option value="">Selecciona un grupo</option>
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo->idGrupo }}">{{$grupo->semestre}}-{{ $grupo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de la evaluación -->
                        <div class="row my-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha de Evaluación:</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Botón para guardar la evaluación -->
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">
                                <br>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para alternar la visibilidad de los combobox
    function toggleCombobox(enabledId, disabledId) {
        var enabledCombobox = document.getElementById(enabledId);
        var disabledCombobox = document.getElementById(disabledId);
        enabledCombobox.disabled = false;
        disabledCombobox.disabled = true;
        disabledCombobox.selectedIndex = 0; // Reset selection
    }
</script>

@endsection