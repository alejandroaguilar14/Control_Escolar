@extends("components.layout")

@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent

<style>
    .card-header {
        background-color: #343a40;
        color: white;
    }

    .table th,
    .table td {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
        border-color: #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
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

<div class="container my-5">
    <h2 class="text-center mb-4">EVALUACIONES DE: {{ $alumnos->nombre }} {{ $alumnos->primerApellido }} {{ $alumnos->segundoApellido }}</h2>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Exámenes Prácticos</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="maintable">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Examen</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluacionesPractico as $evaluacionPractico)
                            <tr>
                                <td>{{ $evaluacionPractico->idEvaluacion }}</td>
                                <td>{{ $evaluacionPractico->tipoExamen }}</td>
                                <td>{{ $evaluacionPractico->examPractico }}</td>
                                <td>{{ $evaluacionPractico->fecha }}</td>
                                <td>{{ $evaluacionPractico->nota }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Exámenes Teóricos</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="maintable2">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Examen</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluacionesTeorico as $evaluacionTeorico)
                            <tr>
                                <td>{{ $evaluacionTeorico->idEvaluacion }}</td>
                                <td>{{ $evaluacionTeorico->tipoExamen }}</td>
                                <td>{{ $evaluacionTeorico->examTeorico }}</td>
                                <td>{{ $evaluacionTeorico->fecha }}</td>
                                <td>{{ $evaluacionTeorico->nota }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        $(document).ready(function() {
            let table = $('#maintable').DataTable({
                paging: {{ $evaluacionesPractico->count() > 10 ? 'true' : 'false' }},
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
        $(document).ready(function() {
            let table = $('#maintable2').DataTable({
                    paging: {{ $evaluacionesTeorico->count() > 10 ? 'true' : 'false' }},
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
