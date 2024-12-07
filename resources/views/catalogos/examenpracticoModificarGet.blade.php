@extends("components.layout")
<!-- Extiende la plantilla base "layout" ubicada en la carpeta "components" -->

@section("content")
<!-- Define la sección "content" que será insertada en la plantilla base -->

@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
@endcomponent
<!-- Incluye el componente de "breadcrumbs" (migas de pan) y le pasa la variable $breadcrumbs -->

<style>
    /* Estilos personalizados para la vista */
    .card-header {
        background-color: #343a40;
        color: white;
    }

    .input-label {
        color: #343a40;
    }

    .input-style {
        border: 2px solid #6c757d;
        padding: 5px;
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
</style>

<!-- Contenedor principal con márgenes superiores para espaciado -->
<div class="container mt-5">
    <!-- Tarjeta con sombra para darle un efecto de elevación -->
    <div class="card shadow">
        <!-- Encabezado de la tarjeta con fondo oscuro y texto blanco -->
        <div class="card-header bg-secondary text-white">
            <h1 class="mb-0 text-center">Modificar datos del examen práctico</h1>
        </div>
        <!-- Cuerpo de la tarjeta -->
        <div class="card-body">
            <!-- Formulario para modificar los datos del examen práctico -->
            <form method="post" action='{{ url("/catalogos/examenpractico/" . $examPractico->idExamenPractico . "/modificar") }}'>
                @csrf
                <!-- Token CSRF para seguridad en formularios -->

                <!-- Fila para el campo de título -->
                <div class="row my-2">
                    <div class="form-group">
                        <label for="titulo" class="input-label">Título:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control input-style" value="{{ $examPractico->titulo }}" autofocus>
                    </div>
                </div>

                <!-- Fila para el campo de grado de dificultad -->
                <div class="row my-2">
                    <div class="form-group">
                        <label for="gradoDificultad" class="input-label">Grado de dificultad:</label>
                        <select class="form-control input-style" id="gradoDificultad" name="gradoDificultad" autofocus>
                            <!-- Opción predeterminada seleccionada -->
                            <option value="{{ $examPractico->gradoDificultad }}" selected>{{ $examPractico->gradoDificultad }}</option>
                            
                            <!-- Otras opciones excluyendo la predeterminada -->
                            @foreach(['BAJO', 'MEDIO', 'ALTO'] as $grado)
                                @if($grado !== $examPractico->gradoDificultad)
                                    <option value="{{ $grado }}">{{ $grado }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botones para guardar y regresar -->
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href='{{ url("/catalogos/examenpractico") }}' class="btn btn-dark">Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<!-- Fin de la sección "content" -->
