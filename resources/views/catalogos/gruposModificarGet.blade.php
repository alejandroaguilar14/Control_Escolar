@extends("components.layout") <!-- Extiende la plantilla layout -->

@section("content") <!-- Define el bloque de contenido -->

<style>
    /* Estilos CSS para el formulario */
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

    h1 {
        color: white;
    }
</style>

<div class="container mt-5">
    <!-- Mensajes de éxito o error -->
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
                    <h1 class="mb-0">Modificar Grupo</h1>
                </div>
                <div class="card-body">
                    <!-- Formulario para modificar el grupo -->
                    <form method="post" action="{{ url('/catalogos/grupos/' . $grupo->idGrupo . '/modificar') }}" onsubmit="return validateForm()">
                        @csrf <!-- Token CSRF -->
                        @method('PUT') <!-- Método HTTP PUT -->

                        <div class="row my-2">
                            <div class="form-group col-md-12">
                                <label for="nombre">Nombre del Grupo:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" maxlength="1" pattern="[A-Za-z]" title="Debe ser una sola letra." oninput="this.value = this.value.toUpperCase()" value="{{ $grupo->nombre }}" required>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="form-group col-md-12">
                                <label for="semestre">Semestre:</label>
                                <input type="number" name="semestre" id="semestre" class="form-control" min="1" max="6" value="{{ $grupo->semestre }}" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">
                                <br>
                                <button type="submit" class="btn btn-primary">Modificar Grupo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para validar el formulario antes de enviarlo
    function validateForm() {
        var nombre = document.getElementById('nombre').value;
        var semestre = document.getElementById('semestre').value;

        // Validar que el campo nombre sea una sola letra
        if (!/^[A-Za-z]$/.test(nombre)) {
            alert('El nombre del grupo debe ser una sola letra.');
            return false;
        }

        // Validar que el semestre esté entre 1 y 6
        if (semestre < 1 || semestre > 6) {
            alert('El semestre debe ser un número entre 1 y 6.');
            return false;
        }

        return true; // Permitir el envío del formulario si pasa todas las validaciones
    }
</script>

@endsection <!-- Fin del bloque de contenido -->
