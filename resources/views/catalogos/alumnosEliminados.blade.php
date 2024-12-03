@extends("components.layout")
@if(session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    <?php session()->forget('success'); ?>
@endif
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent
    <style>
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
    <!-- Contenido principal mostrando todos los datos de los alumnos eliminados -->
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col">
                <h1>Alumnos suspendidos</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-fluid " id="maintable"> 
                    <thead> 
                        <tr> 
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">NOMBRE</th>
                            <th scope="col" class="text-center">NIF</th>
                            <th scope="col" class="text-center">GRUPO</th>
                            <th scope="col"class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($alumnosInactivos as $alumno) 
                            <tr>
                                <td class="text-center">{{ $alumno['idAlumno'] }}</td>
                                <td class="text-center">{{ $alumno['nombre'] }} {{ $alumno['primerApellido'] }} {{ $alumno['segundoApellido'] }}</td>
                                <td class="text-center">{{ $alumno['NIF'] }}</td>
                                <td class="text-center">{{ $alumno['grupo'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activateModal{{$alumno['idAlumno']}}">Activar</button>
                                    <div class="modal fade" id="activateModal{{$alumno['idAlumno']}}" tabindex="-1" aria-labelledby="activateModalLabel{{$alumno['idAlumno']}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="activateModalLabel{{$alumno['idAlumno']}}">Confirmar Activación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas activar este alumno?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="{{ url("/catalogos/alumnos/{$alumno['idAlumno']}/activar") }}" class="btn btn-primary">Activar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    
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
                <a href='{{ url("/catalogos/alumnos") }}' class="btn btn-dark">Alumnos en curso</a>
            </div>
            
        </div>
    </div>
    <script>
        $(document).ready(function() {

            setTimeout(function(){
                $('#success-message').fadeOut('slow');
            }, 3000); // 3000 milisegundos = 3 segundos
            
            let table = $('#maintable').DataTable({
                paging: {{ $alumnosInactivos->count() > 10 ? 'true' : 'false' }},
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


