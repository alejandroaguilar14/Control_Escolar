@extends("components.layout")
<!-- Extiende la plantilla base llamada "layout" que se encuentra en la carpeta components -->

@section("content")
<!-- Define la sección "content" que será insertada en la plantilla base -->

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
                        <h1 class="mb-0 text-center">Modificar Datos del Alumno</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action='{{url("/catalogos/alumnos/" . $alumno->idAlumno . "/modificar")}}'>
                            @csrf
                            <!-- Campo de nombre -->
                            <div class="form-group">
                                <label for="nombre" class="input-label">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control input-style" value="{{$alumno->nombre}}" autofocus>
                            </div>
                            <!-- Campo de primer apellido -->
                            <div class="form-group">
                                <label for="primerApellido" class="input-label">Primer Apellido:</label>
                                <input type="text" name="primerApellido" id="primerApellido" class="form-control input-style" value="{{$alumno->primerApellido}}" autofocus>
                            </div>
                            <!-- Campo de segundo apellido -->
                            <div class="form-group">
                                <label for="segundoApellido" class="input-label">Segundo Apellido:</label> 
                                <input type="text" name="segundoApellido" id="segundoApellido" class="form-control input-style" value="{{$alumno->segundoApellido}}" autofocus>
                            </div>
                            <!-- Campo de grupo -->
                            <div class="form-group">
                                <label for="grupo" class="input-label">Grupo:</label>
                                <select name="grupo" id="grupo" class="form-control input-style" autofocus>
                                    <option value="{{$alumno->fk_idGrupo}}" selected>{{ $alumno->semestre_nombre_grupo }}</option>
                                    @foreach($grupos as $g)
                                        @if($g->idGrupo != $alumno->fk_idGrupo)
                                            <option value="{{$g->idGrupo}}">{{$g->grupo}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <!-- Campo de NIF -->
                            <div class="form-group">
                                <label for="NIF" class="input-label">NIF:</label>
                                <input type="number" name="NIF" id="NIF" class="form-control input-style" value="{{$alumno->NIF}}" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);" required>
                            </div>
                            <!-- Botones de acción -->
                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary">Guardar</button> 
                                <a href='{{ url("/catalogos/alumnos") }}' class="btn btn-dark">Regresar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- Fin de la sección "content" -->
