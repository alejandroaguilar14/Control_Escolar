@extends("components.layout")
<!-- Extiende la plantilla base llamada "layout" que se encuentra en la carpeta components -->

@section("content")
<!-- Define la sección "content" que será insertada en la plantilla base -->

@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
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
        min-width: 800px;
    }
</style>
<!-- Muestra en una tabla todos los campos de un examen practico -->
<div class="container-fluid">
    <div class="row">
        <div class="col content">
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Examen Práctico</h1>
                    <div class="titlebar-commands">
                        <a class="btn btn-primary" href="{{ url('/catalogos/examenpractico/agregar') }}">Agregar</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-fluid" id="maintable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">TÍTULO</th>
                                        <th scope="col">GRADO DE DIFICULTAD</th>
                                        <th scope="col">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($examenespracticos as $examenpractico)
                                        <tr>
                                            <td class="text-center">{{ $examenpractico->idExamenPractico }}</td>
                                            <td class="text-center">{{ $examenpractico->titulo }}</td>
                                            <td class="text-center">{{ $examenpractico->gradoDificultad }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-dark" href="{{ url("/catalogos/examenpractico/{$examenpractico->idExamenPractico}/profesores") }}">Profesores</a> |
                                                <a class="btn btn-success" href="{{ url("/catalogos/examenpractico/{$examenpractico->idExamenPractico}/modificar") }}">Modificar</a>
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
        // Inicializa la tabla con DataTables
        let table = $('#maintable').DataTable({
            paging: {{ $examenespracticos->count() > 10 ? 'true' : 'false' }}, // Activa la paginación si hay más de 10 registros
            searching: true, // Activa el campo de búsqueda
            order: [[0, 'asc']], // Ordena por la primera columna (ID) en orden ascendente
            lengthChange: false, // Desactiva el select para cambiar el número de registros mostrados
            language: { // Personaliza los textos mostrados en la tabla
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
