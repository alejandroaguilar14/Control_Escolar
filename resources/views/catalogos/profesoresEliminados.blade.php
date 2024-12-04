@extends("components.layout")
@if(session('success'))
    <!-- Muestra un mensaje de éxito si existe -->
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    <?php session()->forget('success'); ?> <!-- Borra el mensaje de éxito de la sesión -->
@endif
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <!-- Contenido principal -->
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col">
                <h1>Profesores suspendidos</h1> <!-- Título de la sección -->
            </div>
        </div>
    </div>

    <!-- Tarjeta con la lista de profesores suspendidos -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-fluid" id="maintable"> <!-- Tabla de profesores suspendidos -->
                    <thead> <!-- Encabezados de la tabla -->
                        <tr> 
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">NOMBRE</th>
                            <th scope="col" class="text-center">NIF</th>
                            <th scope="col"class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> <!-- Cuerpo de la tabla -->
                        @foreach($profesoresInactivos as $profesor) <!-- Iteración sobre los profesores suspendidos -->
                            <tr>
                                <!-- Datos del profesor -->
                                <td class="text-center">{{$profesor->idProfesor}}</td>
                                <td class="text-center">{{$profesor->nombre}} {{$profesor->primerApellido}} {{$profesor->segundoApellido}}</td>
                                <td class="text-center">{{$profesor->NIF}}</td>
                                <td class="text-center">
                                    <!-- Botón para activar al profesor -->
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activateModal{{$profesor['idProfesor']}}">Activar</button>

                                    <!-- Modal de confirmación para activar al profesor -->
                                    <div class="modal fade" id="activateModal{{$profesor['idProfesor']}}" tabindex="-1" aria-labelledby="activateModalLabel{{$profesor['idProfesor']}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="activateModalLabel{{$profesor['idProfesor']}}">Confirmar Activación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas activar este profesor?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="{{ url("/catalogos/profesores/{$profesor['idProfesor']}/activar") }}" class="btn btn-primary">Activar</a>
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

    <!-- Botón de regreso -->
    <div class="container-fluid">  
        <div class="row my-4">
            <div class="col"></div>
            <div class="col-auto titlebar-commands">
                <a href='{{ url("/catalogos/profesores") }}' class="btn btn-dark">Profesores activos</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {

            // Oculta el mensaje de éxito después de 3 segundos
            setTimeout(function(){
                $('#success-message').fadeOut('slow');
            }, 3000);

            // Inicializa la tabla de profesores suspendidos
            let table = $('#maintable').DataTable({
                paging: {{ $profesoresInactivos->count() > 10 ? 'true' : 'false' }}, // Activa o desactiva la paginación según la cantidad de profesores
                searching: true, // Habilita la búsqueda en la tabla
                order: [[0, 'asc']], // Ordena por la primera columna en orden ascendente
                lengthChange: false, // Desactiva el select para cambiar el número de registros mostrados
                language: { // Configuración del lenguaje de la tabla
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
