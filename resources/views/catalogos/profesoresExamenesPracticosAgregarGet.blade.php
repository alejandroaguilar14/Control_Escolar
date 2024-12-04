@extends("components.layout")

@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <!-- Estilos CSS -->
    <style>
        .card-header {
            background-color: #343a40;
            color: white;
        }

        .input-label {
            color: #343a40;
        }

        .input-style {
            border: 2px solid #6c757d;
            padding: 5px;
        }

        .input-style:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 10px #007bff;
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

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h1 class="mb-0 text-center">Agregar profesores</h1> <!-- Título de la página -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{url('/catalogos/examenpractico/' . $examPractico->idExamenPractico . '/profesores/agregar')}}" id="formExamenPractico">
                            @csrf
                            <div class="form-group my-3">
                                <div class="row my-3">
                                    <h3 class="text-center">Examen Práctico: {{ $examPractico->titulo}}</h3> <!-- Título del examen práctico -->
                                </div>
                                <label for="profesor" class="input-label">Seleccionar Profesor:</label>
                                <div class="input-group">
                                    <select id="profesor" class="form-control input-style">
                                        <option value="">Seleccione un profesor...</option>
                                        @foreach($profesores as $profesor)
                                            @if (!in_array($profesor->idProfesor, $profesoresSeleccionados))
                                                <option value="{{ $profesor->idProfesor }}" data-nombre="{{ $profesor->nombre }}" data-primerApellido="{{ $profesor->primerApellido }}" data-segundoApellido="{{ $profesor->segundoApellido }}">
                                                    {{ $profesor->nombre }} {{ $profesor->primerApellido }} {{ $profesor->segundoApellido }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="date" id="fechaParticipacion" class="form-control input-style">
                                    <button type="button" class="btn btn-secondary" onclick="agregarProfesor()">Agregar</button>
                                </div>
                            </div>
                            <div class="form-group my-3">
                                <label for="profesorSeleccionado" class="input-label">Profesores seleccionados:</label>
                                <ul id="selectedProfesores" class="list-group"></ul> <!-- Lista de profesores seleccionados -->
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Guardar</button> <!-- Botón para guardar los profesores seleccionados -->
                                    <a href='{{ url("/catalogos/examenpractico/$examPractico->idExamenPractico/profesores") }}' class="btn btn-dark">Regresar</a> <!-- Botón para regresar -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Función para agregar un profesor a la lista de seleccionados
        function agregarProfesor() { 
            const selectProfesor = document.getElementById('profesor');
            const profesorId = selectProfesor.value;
            const profesorNombre = selectProfesor.options[selectProfesor.selectedIndex].text;
            const fechaParticipacion = document.getElementById('fechaParticipacion').value;

            if (profesorId && fechaParticipacion) {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.innerHTML = `
                    ${profesorNombre} - ${fechaParticipacion}
                    <input type="hidden" name="profesores[]" value="${profesorId}">
                    <input type="hidden" name="fechasParticipacion[${profesorId}]" value="${fechaParticipacion}">
                    <button type="button" class="btn btn-danger btn-sm float-right" onclick="eliminarProfesor(this)">Eliminar</button>
                `;
                document.getElementById('selectedProfesores').appendChild(li);

                // Eliminar el profesor seleccionado de la lista desplegable
                selectProfesor.remove(selectProfesor.selectedIndex);

                // Limpiar los campos después de agregar
                selectProfesor.value = '';
                document.getElementById('fechaParticipacion').value = '';
            } else {
                alert('Por favor, seleccione un profesor y una fecha de participación.');
            }
        }

        // Función para eliminar un profesor de la lista de seleccionados
        function eliminarProfesor(button) {
            const li = button.closest('li');
            const profesorId = li.querySelector('input[name="profesores[]"]').value;
            const profesorNombre = li.textContent.trim().split(' - ')[0]; // Obtener el nombre del profesor

            // Crear una opción para el select con el profesor eliminado
            const option = document.createElement('option');
            option.value = profesorId;
            option.text = profesorNombre;

            // Insertar la opción en el select en orden alfabético
            const selectProfesor = document.getElementById('profesor');
            const options = Array.from(selectProfesor.options);
            options.push(option);
            options.sort((a, b) => a.text.localeCompare(b.text));
            selectProfesor.innerHTML = '';
            options.forEach(opt => selectProfesor.appendChild(opt));

            // Eliminar el elemento de la lista
            li.remove();
        }
    </script>
@endsection
