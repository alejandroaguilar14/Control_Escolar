@extends("components.layout")
@section("content")
    <!-- Sección de migas de pan -->
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <!-- Encabezado de la página -->
    <div class="row my-4">
        <div class="col">
            <h4>Examenes</h4>
        </div>
    </div>

    <!-- Botones para ver y descargar PDF -->
    <div class="row my-2">
        <div class="col">
            @if(isset($evaluaciones) && count($evaluaciones) > 0)
                <div class="d-flex justify-content-end">
                    <form method="get" action="{{ url('/reportes/examenespdfGet') }}" target='__blank' >
                        <input type="hidden" name="fechaIn" value="{{ request('fechaIn') }}">
                        <input type="hidden" name="fechaFin" value="{{ request('fechaFin') }}">
                        <input type="hidden" name="idExamen" value="{{ request('idExamen') }}">
                        <input type="hidden" name="tipoExamen" value="{{ request('tipoExamen') }}">
                        <button type="submit" class="btn btn-info">Ver PDF</button>
                    </form>
                    <form method="get" action="{{ url('/reportes/examenesdownloadpdfGet') }}" target='__blank' >
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
    <form class="card p-4 my-4" action="{{ url('/reportes/examenes') }}" method="get">
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

    <!-- Tabla con información de las evaluaciones -->
    <table class="table"> 
        <thead> 
            <tr> 
                <th scope="col" class="text-center">Examen</th>
                <th scope="col" class="text-center">Total de alumnos</th>
                <th scope="col" class="text-center">Porcentaje de aprobados</th>
                <th scope="col" class="text-center">Porcentaje de reprobados</th>
            </tr>
        </thead>
        <tbody> 
                <tr>
                    @if(count($evaluaciones) > 0)
                        <td class="text-center">{{$evaluaciones[0]->TituloExam}}</td>
                        <td class="text-center">{{$evaluaciones[0]->TotalAlumnos}}</td>
                        <td class="text-center">{{ number_format($evaluaciones[0]->PorcentajeAprobados, 2) }}%</td>
                        <td class="text-center">{{ number_format($evaluaciones[0]->PorcentajeReprobados, 2) }}%</td>
                    @endif
                </tr>
        </tbody>
    </table>

    <!-- Gráfica de pastel con porcentajes de aprobados y reprobados -->
    <div class="row my-4">
        <div class="col">
            <canvas id="graficaPastel" width="400" height="400"></canvas>
        </div>
    </div>

    <!-- Script para generar la gráfica de pastel -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        @if(count($evaluaciones) > 0)
            var porcentajeAprobados = {{ $evaluaciones[0]->PorcentajeAprobados }};
            var porcentajeReprobados = {{ $evaluaciones[0]->PorcentajeReprobados }};
        @else
            var porcentajeAprobados = 0;
            var porcentajeReprobados = 0;
        @endif

        var data = {
            labels: ["Aprobados", "Reprobados"],
            datasets: [{
                data: [porcentajeAprobados, porcentajeReprobados],
                backgroundColor: [
                    'rgba(10, 20, 130, 0.8)',  // Azul oscuro
                    'rgba(130, 0, 0, 0.8)'     // Rojo oscuro
                ],
                borderColor: [
                    'rgba(10, 20, 130, 1)',  // Borde azul oscuro
                    'rgba(130, 0, 0, 1)'     // Borde rojo oscuro
                ],
                borderWidth: 1
            }]
        };

        var options = {
            responsive: true,
            maintainAspectRatio: false
        };

        var ctx = document.getElementById('graficaPastel').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });

        // Cuando la gráfica esté lista, enviar la imagen al servidor
        myPieChart.update();
        setTimeout(() => {
            var image = myPieChart.toBase64Image();
            $.ajax({
                type: "POST",
                url: "{{ url('/guardar-grafica') }}",
                data: {
                    image: image,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log("Imagen guardada:", data);
                },
                error: function(error) {
                    console.log("Error al guardar la imagen:", error);
                }
            });
        }, 1000);  // Esperar a que la gráfica se dibuje completamente
    </script>
    
@endsection
