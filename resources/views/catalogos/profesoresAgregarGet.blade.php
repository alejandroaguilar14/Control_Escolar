@extends("components.layout") <!-- Extiende la plantilla layout -->

@section("content") <!-- Define el bloque de contenido -->

@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs]) <!-- Incluye el componente de migas de pan -->
@endcomponent

<style>
    /* Estilos CSS para la página */
    .card-header {
        background-color: #343a40; /* Color de fondo del encabezado de la tarjeta */
        color: white; /* Color del texto del encabezado de la tarjeta */
    }

    .input-label {
        color: #343a40; /* Color del texto de las etiquetas de entrada */
    }

    .input-style {
        border: 2px solid #6c757d; /* Estilo del borde de las entradas */
        padding: 10px; /* Espaciado interno de las entradas */
    }

    .input-style:focus {
        outline: none; /* Elimina el contorno al enfocar la entrada */
        border-color: #007bff; /* Color del borde al enfocar la entrada */
        box-shadow: 0 0 10px #007bff; /* Sombra al enfocar la entrada */
    }

    .btn-primary {
        background-color: #007bff; /* Color de fondo del botón primario */
        border-color: #007bff; /* Color del borde del botón primario */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Color de fondo del botón primario al pasar el mouse */
        border-color: #0056b3; /* Color del borde del botón primario al pasar el mouse */
    }
</style>

<div class="container mt-5"> <!-- Contenedor principal -->
    <div class="row justify-content-center"> <!-- Fila centrada -->
        <div class="col-lg-8"> <!-- Columna de ancho grande -->
            <div class="card shadow"> <!-- Tarjeta con sombra -->
                <div class="card-header bg-secondary text-white"> <!-- Encabezado de la tarjeta -->
                    <h1 class="mb-0 text-center">Agregar Profesor</h1> <!-- Título centrado -->
                </div>
                <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                    <form method="post" action="{{ url('/catalogos/profesores/agregar') }}"> <!-- Formulario de agregar profesor -->
                        @csrf <!-- Token CSRF -->
                        <div class="form-group">
                            <label for="nombre" class="input-label">Nombre:</label> <!-- Etiqueta y entrada para el nombre -->
                            <input type="text" maxlength="50" name="nombre" id="nombre" placeholder="Ingrese nombre del profesor" class="form-control input-style" required autofocus> <!-- Entrada de texto para el nombre -->
                        </div>
                        <div class="form-group">
                            <label for="primerApellido" class="input-label">Primer Apellido:</label> <!-- Etiqueta y entrada para el primer apellido -->
                            <input type="text" maxlength="50" name="primerApellido" id="primerApellido" placeholder="Ingrese el primer apellido del profesor" class="form-control input-style" required autofocus> <!-- Entrada de texto para el primer apellido -->
                        </div>
                        <div class="form-group">
                            <label for="segundoApellido" class="input-label">Segundo Apellido:</label> <!-- Etiqueta y entrada para el segundo apellido -->
                            <input type="text" maxlength="50" name="segundoApellido" id="segundoApellido" placeholder="Ingrese el segundo apellido del profesor" class="form-control input-style" required autofocus> <!-- Entrada de texto para el segundo apellido -->
                        </div>
                        <div class="form-group">
                            <label for="NIF" class="input-label">NIF:</label> <!-- Etiqueta y entrada para el NIF -->
                            <input type="number" name="NIF" id="NIF" class="form-control input-style" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);" required> <!-- Entrada numérica para el NIF -->
                        </div>
                        <div class="row justify-content-center"> <!-- Fila centrada para botones -->
                            <div class="col-auto"> <!-- Columna de ancho automático -->
                                <button type="submit" class="btn btn-primary">Guardar</button> <!-- Botón para guardar el profesor -->
                                <a href='{{ url("/catalogos/profesores") }}' class="btn btn-dark">Regresar</a> <!-- Botón para regresar -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection <!-- Fin del bloque de contenido -->
