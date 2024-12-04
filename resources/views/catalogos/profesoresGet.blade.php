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
    <div class="container-fluid">
    <!-- Encabezado de la página -->
    <div class="row">
        <div class="col content">
            <!-- Título de la sección y botón de agregar -->
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Profesores</h1>
                    <div class="titlebar-commands">
                        <a class="btn btn-primary" href="{{url('/catalogos/profesores/agregar')}}">Agregar</a>
                    </div>
                </div>
                <!-- Contenedor de la tabla de profesores -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Tabla de profesores -->
                            <table class="table table-bordered table-fluid" id="maintable"> 
                                <thead> 
                                    <tr> 
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col" class="text-center">NOMBRE</th>
                                        <th scope="col" class="text-center">NIF</th>
                                        <th scope="col" class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <!-- Bucle para mostrar cada profesor -->
                                    @foreach($profesores as $profesor) 
                                        <tr>
                                            <!-- ID del profesor -->
                                            <td class="text-center">{{$profesor->idProfesor}}</td>
                                            <!-- Nombre completo del profesor -->
                                            <td class="text-center">{{$profesor->nombre}} {{$profesor->primerApellido}} {{$profesor->segundoApellido}}</td>
                                            <!-- NIF del profesor -->
                                            <td class="text-center">{{$profesor->NIF}}</td>
                                            <!-- Acciones: Modificar y Deshabilitar -->
                                            <td class="text-center">
                                                <a href='{{url("/catalogos/profesores/{$profesor->idProfesor}/modificar")}}'  class="btn btn-success">Modificar</a> |
                                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$profesor['idProfesor']}}">Deshabilitar</button>
                                            </td>
                                            <!-- Modal de confirmación para deshabilitar al profesor -->
                                            <div class="modal fade" id="deleteModal{{$profesor['idProfesor']}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$profesor['idProfesor']}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$profesor['idProfesor']}}">Confirmar acción</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas deshabilitar al profesor {{ $profesor['nombre'] }} {{ $profesor['primerApellido'] }} {{ $profesor['segundoApellido'] }}?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <a href="{{ url("/catalogos/profesores/{$profesor['idProfesor']}/eliminar") }}" class="btn btn-danger">Aceptar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Botón para mostrar los profesores eliminados -->
<div class="container-fluid">  
    <div class="row my-4">
        <div class="col">
        </div>
        <div class="col-auto titlebar-commands">
            <a href='{{ url("/catalogos/profesores/eliminados") }}' class="btn btn-dark">Profesores anteriores</a>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {

            setTimeout(function(){
                $('#success-message').fadeOut('slow');
            }, 3000); // 3000 milisegundos = 3 segundos
            
            let table = $('#maintable').DataTable({
                paging: {{ $profesores->count() > 10 ? 'true' : 'false' }},
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

