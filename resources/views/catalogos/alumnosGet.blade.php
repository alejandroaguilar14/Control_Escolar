@extends("components.layout") 
<!-- Extiende la plantilla base llamada "layout" que se encuentra en la carpeta components -->

@if(session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    <?php session()->forget('success'); ?>
@endif
<!-- Si existe un mensaje de éxito en la sesión, se muestra dentro de una alerta y luego se elimina de la sesión -->

@section("content")
<!-- Define una sección llamada "content" que será insertada en la plantilla base -->

    @component("components.breadcrumbs", ["breadcrumbs"=>$breadcrumbs])
    @endcomponent
    <!-- Incluye el componente de "breadcrumbs" (migas de pan) y le pasa la variable $breadcrumbs -->

    <style>
        /* Estilos personalizados para la vista */
        .content {
            transition: margin-left 0.3s;
            width: 100%;
        }

        .sidebar.active ~ .content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .titlebar-commands {
            display: flex;
            align-items: center;
        }

        .btn-primary {
            margin-left: 10px;
        }

        .table td, .table th {
            text-align: center;
        }

        .table-fluid {
            width: 100%;
        }

        .table {
            min-width: 800px; /* Ajusta el ancho mínimo de la tabla según sea necesario */
        }
    </style>

    <!-- Contenido principal -->
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col">
                <h1>Alumnos</h1>
            </div>
            <div class="col-auto titlebar-commands">
                <a class="btn btn-primary" href="{{ url('/catalogos/alumnos/agregar') }}">Agregar</a>
            </div>
            <!-- Botón para agregar un nuevo alumno -->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-fluid" id="maintable"> 
                    <thead> 
                        <tr> 
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">NOMBRE</th>
                            <th scope="col" class="text-center">NIF</th>
                            <th scope="col" class="text-center">GRUPO</th>
                            <th scope="col" class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($alumnos as $alumno) 
                            <tr>
                                <td class="text-center">{{ $alumno['idAlumno'] }}</td>
                                <td class="text-center">{{ $alumno['nombre'] }} {{ $alumno['primerApellido'] }} {{ $alumno['segundoApellido'] }}</td>
                                <td class="text-center">{{ $alumno['NIF'] }}</td>
                                <td class="text-center">{{ $alumno['grupo'] }}</td>
                                <td class="text-center">
                                    <a href='{{ url("/movimientos/alumnos/{$alumno['idAlumno']}/evaluaciones") }}' class="btn btn-dark">Evaluaciones</a> |
                                    <a href='{{ url("/catalogos/alumnos/{$alumno['idAlumno']}/modificar") }}' class="btn btn-success">Modificar</a> |
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$alumno['idAlumno']}}">Dar de baja</button>
                                </td>
                                <!-- Modal para confirmar la eliminación del alumno -->
                                <div class="modal fade" id="deleteModal{{$alumno['idAlumno']}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$alumno['idAlumno']}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{$alumno['idAlumno']}}">Confirmar acción</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas dar de baja al alumno {{ $alumno['nombre'] }} {{ $alumno['primerApellido'] }} {{ $alumno['segundoApellido'] }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <a href="{{ url("/catalogos/alumnos/{$alumno['idAlumno']}/eliminar") }}" class="btn btn-danger">Aceptar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin del modal -->
                            </tr>
                        @endforeach
                        <!-- Itera sobre la colección de alumnos ($alumnos) y muestra cada uno en una fila de la tabla con opciones para ver evaluaciones, modificar y dar de baja -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container-fluid">  
        <div class="row my-4">
            <div class="col">
            </div>
            <div class="col-auto titlebar-commands">
                <a href='{{ url("/catalogos/alumnos/eliminados") }}' class="btn btn-dark">Alumnos Suspendidos</a>
            </div>
            <!-- Botón para ver la lista de alumnos suspendidos -->
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            // Inicializa el DataTable en la tabla con ID 'maintable'
            let table = $('#maintable').DataTable({
                paging: {{ $alumnos->count() > 10 ? 'true' : 'false' }},
                searching: true,
                order: [[0, 'asc']], // Ordena por la primera columna en orden ascendente
                lengthChange: false, // Desactiva el select para cambiar el número de registros mostrados
                language: {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna ascendente",
                        "sortDescending": ": activar para ordenar la columna descendente"
                    }
                }
            });
        });
    </script>
@endsection
<!-- Fin de la sección "content" -->
