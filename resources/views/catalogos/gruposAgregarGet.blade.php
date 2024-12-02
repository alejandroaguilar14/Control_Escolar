@extends("components.layout") 
@section("content")

<!-- Estilos personalizados -->
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

    h1 {
        color: white;
    }
</style>

<div class="container mt-5">
    <!-- Mensajes de error y éxito -->
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

    <!-- Formulario de Agregar Grupo -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0">Agregar Grupo</h1>
                </div>
                <div class="card-body">
                    <!-- Formulario con validación en el envío -->
                    <form method="post" action="{{ url('/catalogos/grupos/agregar') }}" onsubmit="return validateForm()">
                        @csrf  <!-- Protección contra CSRF -->
                        
                        <!-- Campo de Nombre del Grupo -->
                        <div class="row my-2">
                            <div class="form-group col-6">
                                <label for="nombre">Nombre del Grupo:</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Ingrese nombre del grupo [A-Z]" class="form-control" maxlength="1" pattern="[A-Za-z]" title="Debe ser una sola letra." required>
                            </div>
                        </div>

                        <!-- Campo de Semestre -->
                        <div class="row my-2">
                            <div class="form-group col-6">
                                <label for="semestre">Semestre:</label>
                                <input type="number" name="semestre" id="semestre" placeholder="Ingrese el semestre [1-6]" class="form-control" min="1" max="6" required>
                            </div>
                        </div>

                        <hr>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">
                                <br>
                                <button type="submit" class="btn btn-primary">Agregar Grupo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validación en JavaScript -->
<script>
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

        return true;
    }
</script>

@endsection
