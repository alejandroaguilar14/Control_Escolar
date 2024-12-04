@extends("components.layout")
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent
    <style>
        .table th, .table td {
            border: 2px solid #6c757d;
        }
        .table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
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
    <div class="row my-4">
        <div class="col">
            <h2>Examen práctico: {{ $examenpractico->titulo }}</h2>
        </div>
        <div class="col-auto titlebar-commands">
            <a class="btn btn-primary" href="{{ url('/catalogos/examenpractico/' . $examenpractico->idExamenPractico . '/profesores/agregar') }}">Agregar</a>
        </div>
    </div>
    <table class="table" id="maintable"> 
        <thead> 
            <tr> 
                <th scope="col" class="text-center">NOMBRE</th>
                <th scope="col" class="text-center">FECHA</th>
                <th scope="col" class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($examenProfesores as $examenProfesor) 
                <tr>
                    <td>{{$examenProfesor->nombreCompleto}}</td>
                    <td>{{$examenProfesor->fechaParticipacion}}</td>
                    <td><a href='{{url("/catalogos/examenpractico/{$examenProfesor->id_det_prof_examPractico}/profesores/modificar")}}' class="btn btn-success">Modificar fecha</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col text-right">
            <a href='{{ url("/catalogos/examenpractico") }}' class="btn btn-dark ml-auto">Regresar</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let table = $('#maintable').DataTable({
                paging: {{ $examenProfesores->count() > 10 ? 'true' : 'false' }},
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