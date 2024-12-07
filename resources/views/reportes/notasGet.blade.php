@extends('components.layout')
@section('content')
    <!-- Sección de migas de pan -->
    @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endcomponent

    <!-- Encabezado de la página -->
    <div class="row my-4">
        <div class="col">
            <h4>Evaluaciones por examen</h4>
        </div>
    </div>

    <!-- Botones para ver y descargar PDF -->
    <div class="row my-2">
        <div class="col">
            @if(isset($evaluaciones) && count($evaluaciones) > 0)
                <div class="d-flex justify-content-end">
                    <form method="get" action="{{ url('/reportes/notaspdfGet') }}" target='__blank' >
                        <input type="hidden" name="fechaIn" value="{{ request('fechaIn') }}">
                        <input type="hidden" name="fechaFin" value="{{ request('fechaFin') }}">
                        <input type="hidden" name="idExamen" value="{{ request('idExamen') }}">
                        <input type="hidden" name="tipoExamen" value="{{ request('tipoExamen') }}">
                        <button type="submit" class="btn btn-info">Ver PDF</button>
                    </form>
                    <form method="get" action="{{ url('/reportes/notasdownloadpdfGet') }}" target='__blank' >
                        <input type="hidden" name="fechaIn" value="{{ request('fechaIn') }}">
                        <input type="hidden" name="fechaFin" value="{{ request('fechaFin') }}">
                        <input type="hidden" name="idExamen" value="{{ request('idExamen') }}">
                        <input type="hidden" name="tipoExamen" value="{{ request('tipoExamen') }}">
                        <button type="submit" class="btn btn-secondary ml-2">Download PDF</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Formulario para filtrar evaluaciones -->
    <form class="card p-4 my-4" action="{{ url('/reportes/notas') }}" method="get">
        <div class="row">
            <!-- Campos de fecha de inicio y fecha de fin -->
            <div class="col form-group">
                <label for="fechaIn">Fecha Inicio</label>
                <input class="form-control" type="date" name="fechaIn" id="fechaIn">
            </div>
            <div class="col form-group">
                <label for="fechaFin">Fecha Fin</label>
                <input class="form-control" type="date" name="fechaFin" id="fechaFin">
            </div>
            <!-- Selector de tipo de examen -->
            <h10>Tipo de Examen:</h10>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoExamen" value="TEORICO" id="checkTeorico" onchange="toggleCombobox('comboboxTeorico', 'comboboxPractico')">
                        <label class="form-check-label" for="checkTeorico">Examen Teórico</label>
                    </div>
                    <!-- Combobox para seleccionar examen teórico -->
                    <div class="form-group">
                        <select class="form-control" id="comboboxTeorico" name="datosExamenTeorico" disabled onchange="updateSelectedExamenId('comboboxTeorico')">
                            <option value="">Selecciona examen teórico</option>
                            @foreach($examenesTeoricos as $examenTeorico)
                                <option value="{{ $examenTeorico->idExamenTeorico }}">{{ $examenTeorico->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoExamen" value="PRACTICO" id="checkPractico" onchange="toggleCombobox('comboboxPractico', 'comboboxTeorico')">
                        <label class="form-check-label" for="checkPractico">Examen Práctico</label>
                    </div>
                    <!-- Combobox para seleccionar examen práctico -->
                    <div class="form-group">
                        <select class="form-control" id="comboboxPractico" name="datosExamenPractico" disabled onchange="updateSelectedExamenId('comboboxPractico')">
                            <option value="">Selecciona examen práctico</option>
                            @foreach($examenesPracticos as $examenPractico)
                                <option value="{{ $examenPractico->idExamenPractico }}">{{ $examenPractico->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Campo oculto para almacenar el ID del examen seleccionado -->
            <input type="hidden" id="idExamen" name="idExamen">
            <!-- Script para controlar los combobox -->
            <script>
            function toggleCombobox(enabledId, disabledId) {
                var enabledCombobox = document.getElementById(enabledId);
                var disabledCombobox = document.getElementById(disabledId);
                enabledCombobox.disabled = false;
                disabledCombobox.disabled = true;
                disabledCombobox.selectedIndex = 0; // Reset selection
            }
            function updateSelectedExamenId(comboboxId) {
                var combobox = document.getElementById(comboboxId);
                if(combobox.selectedIndex >= 0) {  // Verifica que hay una selección válida
                    var selectedId = combobox.options[combobox.selectedIndex].value;
                    document.getElementById('idExamen').value = selectedId;
                }
            }
            </script>
            <!-- Botón para enviar el formulario de filtrado -->
            <div class="col-auto">
                <br>
                <button type="submit" class="btn-primary btn">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Título del examen seleccionado -->
    <div class="row my-4">
        <div class="col">
            @if(isset($examen->titulo))
                <h4>{{ $examen->titulo }}</h4>
            @else
                <h4>Examen</h4>
            @endif
        </div>
    </div>

    <!-- Tabla con información de las evaluaciones -->
    <table class="table" id="maintable">
        <thead>
            <tr>
                <th class="text-center">FECHA</th>
                <th class="text-center">ALUMNO</th>
                <th class="text-center">NOTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluaciones as $evaluacion) 
                <tr>
                    <td class="text-center">{{$evaluacion->fecha}}</td>
                    <td class="text-center">{{$evaluacion->nombreAlumno}}</td>
                    <td class="text-center">{{$evaluacion->nota}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Script para inicializar la tabla -->
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
