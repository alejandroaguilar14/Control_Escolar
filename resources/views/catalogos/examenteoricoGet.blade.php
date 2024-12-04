@extends("components.layout")
<!-- Extiende la plantilla base "layout" ubicada en la carpeta "components" -->

@section("content")
<!-- Define la sección "content" que será insertada en la plantilla base -->

    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent
    <!-- Incluye el componente de "breadcrumbs" (migas de pan) y le pasa la variable $breadcrumbs -->

    <style>
        /* Estilos personalizados para la vista */
        .row.my-4 {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .col h1 {
            margin-bottom: 0;
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
            min-width: 800px;
        }
    </style>

    <div class="container-fluid">
        <div class="row my-4">
            <div class="col">
                <h1>Examen Teórico</h1>
            </div>
            <div class="col-auto titlebar-commands">
                <a class="btn btn-primary" href="{{ url('/catalogos/examenteorico/agregar') }}">Agregar</a>
            </div>
        </div>
    </div>
    <!-- Contenedor principal con el título y botón para agregar un nuevo examen teórico -->

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-fluid" id="maintable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">FECHA EXAMEN</th>
                            <th scope="col">NOMBRE PROFESOR</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">NUMERO PREGUNTAS</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examenesteoricos as $examenteorico)
                        <tr>
                            <td class="text-center">{{ $examenteorico->idExamenTeorico }}</td>
                            <td class="text-center">{{ $examenteorico->fecha }}</td>
                            <td class="text-center">{{ $examenteorico->nombreCompleto }}</td>
                            <td class="text-center">{{ $examenteorico->titulo }}</td>
                            <td class="text-center">{{ $examenteorico->numPreguntas }}</td>
                            <td class="text-center">
                                <a class="btn btn-success" href='{{ url("/catalogos/examenteorico/{$examenteorico->idExamenTeorico}/modificar") }}'>Modificar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Tarjeta con la tabla que muestra los exámenes teóricos -->

    <script>
        $(document).ready(function() {
            let table = $('#maintable').DataTable({
                paging: {{ $examenesteoricos->count() > 10 ? 'true' : 'false' }},
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
    <!-- Script de inicialización de DataTables para la tabla de exámenes teóricos -->
@endsection
<!-- Fin de la sección "content" -->
