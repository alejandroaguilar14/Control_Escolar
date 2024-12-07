@extends("components.layout")

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
        <div class="row">
            <!-- Contenido principal -->
            <div class="col content">
                
                <div class="my-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1>Evaluaciones @if($estado == 0) Deshabilitadas @endif</h1>
                        <div class="titlebar-commands">
                            @if($estado == 1)
                                <a class="btn btn-primary" href="{{url('/movimientos/evaluaciones/agregar')}}">Programar Evaluación</a>
                                <a class="btn btn-secondary" href="{{ url('/movimientos/evaluaciones/deshabilitadas') }}">Ver Deshabilitadas</a>
                            @else
                                <a class="btn btn-primary" href="{{url('/movimientos/evaluaciones')}}">Ver Habilitadas</a>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-fluid" id="maintable"> 
                                    <thead> 
                                        <tr> 
                                            <th scope="col" class="text-center">ID</th>
                                            <th scope="col" class="text-center">FECHA</th>
                                            <th scope="col" class="text-center">EXAMEN</th>
                                            <th scope="col" class="text-center">TIPO EXAMEN</th>
                                            <th scope="col" class="text-center">GRUPO</th>
                                            <th scope="col" class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach($evaluaciones as $evaluacion) 
                                            <tr>
                                                <td class="text-center">{{$evaluacion->idEvaluacion}}</td>
                                                <td class="text-center">{{$evaluacion->fecha}}</td>
                                                <td class="text-center">{{$evaluacion->nombreExamen}}</td>
                                                <td class="text-center">{{$evaluacion->tipoExamen}}</td>
                                                <td class="text-center">{{$evaluacion->grupo->semestre}}-{{$evaluacion->grupo->nombre}}</td>
                                                <td class="text-center">
                                                    @if($estado == 1)
                                                        <a href='{{url("/movimientos/evaluaciones/{$evaluacion->idEvaluacion}/modificar")}}' class="btn btn-dark">Modificar</a> |
                                                        <a href='{{url("/movimientos/evaluaciones/{$evaluacion->idEvaluacion}/calificaciones")}}' class="btn btn-success">Calificaciones</a> |
                                                        <a href='{{url("/movimientos/evaluaciones/{$evaluacion->idEvaluacion}/deshabilitar")}}' class="btn btn-danger">Deshabilitar</a>
                                                    @else
                                                        <a href='{{url("/movimientos/evaluaciones/{$evaluacion->idEvaluacion}/habilitar")}}' class="btn btn-success">Habilitar</a>
                                                    @endif
                                                </td>
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
    <script>
        $(document).ready(function() {
            let table = $('#maintable').DataTable({
                paging: {{ $evaluaciones->count() > 10 ? 'true' : 'false' }},
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

