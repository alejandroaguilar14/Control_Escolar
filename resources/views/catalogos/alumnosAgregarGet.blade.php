@extends("components.layout") 
<!-- Extiende la plantilla base llamada "layout" que se encuentra en la carpeta components -->

@section("content") 
<!-- Define una sección llamada "content" que será insertada en la plantilla base -->

    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h1 class="mb-0 text-center">Agregar Alumno</h1>
                    </div>
                    <!-- Encabezado de la tarjeta con un título centrado -->

                    <div class="card-body">
                        <!-- Cuerpo de la tarjeta que contiene el formulario -->
                        <form method="post" action="{{ url('/catalogos/alumnos/agregar') }}">
                            <!-- Formulario para agregar un alumno, enviando los datos a la ruta '/catalogos/alumnos/agregar' -->
                            @csrf
                            <!-- Directiva Blade para generar un token CSRF y proteger contra ataques de falsificación de solicitudes entre sitios -->

                            <div class="form-group">
                                <label for="nombre" class="input-label">Nombre:</label>
                                <input type="text" maxlength="50" name="nombre" id="nombre" placeholder="Ingrese nombre del alumno" class="form-control input-style" required autofocus>
                            </div>
                            <!-- Campo de texto para el nombre del alumno -->

                            <div class="form-group">
                                <label for="primerApellido" class="input-label">Primer Apellido:</label>
                                <input type="text" maxlength="50" name="primerApellido" id="primerApellido" placeholder="Ingrese el primer apellido del alumno" class="form-control input-style" required autofocus>
                            </div>
                            <!-- Campo de texto para el primer apellido del alumno -->

                            <div class="form-group">
                                <label for="segundoApellido" class="input-label">Segundo Apellido:</label>
                                <input type="text" maxlength="50" name="segundoApellido" id="segundoApellido" placeholder="Ingrese el segundo apellido del alumno" class="form-control input-style" required autofocus>
                            </div>
                            <!-- Campo de texto para el segundo apellido del alumno -->

                            <div class="form-group">
                                <label for="grupo" class="input-label">Grupo:</label>
                                <select type="select" name="grupo" id="grupo" class="form-control input-style" required autofocus>
                                    <option value="">Selecciona un grupo</option>
                                    @foreach($grupos as $g)
                                    <option value="{{$g->idGrupo}}">{{$g->grupo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Menú desplegable para seleccionar el grupo del alumno. Los valores se rellenan dinámicamente usando un bucle foreach sobre la variable $grupos -->

                            <div class="form-group">
                                <label for="NIF" class="input-label">NIF:</label>
                                <input type="number" name="NIF" id="NIF" class="form-control input-style" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);" required>
                            </div>
                            <!-- Campo de número para el NIF del alumno, con una longitud máxima de 8 dígitos -->

                            <input type="hidden" name="estado" value="1">
                            <!-- Campo oculto para establecer el estado del alumno a 1 -->

                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary">Guardar</button> 
                                <a href='{{ url("/catalogos/alumnos") }}' class="btn btn-dark">Regresar</a>
                            </div>
                            <!-- Botones para enviar el formulario o regresar a la lista de alumnos -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- Fin de la sección "content" -->
