@extends("components.layout")
<!-- Extiende la plantilla base llamada "layout" que se encuentra en la carpeta components -->

@section("content")
<!-- Define la sección "content" que será insertada en la plantilla base -->

@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent
<!-- Incluye el componente de "breadcrumbs" (migas de pan) y le pasa la variable $breadcrumbs -->

<style>
    /* Estilos personalizados para la vista */
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0 text-center">Agregar Examen Práctico</h1>
                </div>
                <div class="card-body">
                    <form method="post" action='{{url("/catalogos/examenpractico/agregar")}}' id="formExamenPractico">
                        @csrf
                        <!-- Campo para el título del examen -->
                        <div class="form-group my-3">
                            <label for="titulo" class="input-label">Título:</label>
                            <input type="text" maxlength="50" name="titulo" id="titulo" placeholder="Ingrese el título del examen práctico" class="form-control input-style" required autofocus>
                        </div>
                        <!-- Campo para el grado de dificultad -->
                        <div class="form-group my-3">
                            <label for="gradoDificultad" class="input-label">Grado de dificultad:</label>
                            <select name="gradoDificultad" id="gradoDificultad" class="form-control input-style" required>
                                <option>BAJO</option>
                                <option>MEDIO</option>
                                <option>ALTO</option>
                            </select>
                        </div>
                        <!-- Campo para seleccionar profesor y fecha de participación -->
                        <div class="form-group my-3">
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
                        <!-- Campo para mostrar profesores seleccionados -->
                        <div class="form-group my-3">
                            <label for="profesorSeleccionado" class="input-label">Profesores seleccionados:</label>
                            <ul id="selectedProfesores" class="list-group"></ul>   
                        </div>
                        <hr>
                        <!-- Botones de acción -->
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href='{{ url("/catalogos/examenpractico") }}' class="btn btn-dark">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function agregarProfesor() {
        // Obtiene el elemento del select de profesores y los campos de fecha y el select de profesores
        const selectProfesor = document.getElementById('profesor');
        const profesorId = selectProfesor.value; // Obtiene el valor seleccionado (id del profesor)
        const profesorNombre = selectProfesor.options[selectProfesor.selectedIndex].text; // Obtiene el nombre del profesor seleccionado
        const fechaParticipacion = document.getElementById('fechaParticipacion').value; // Obtiene la fecha de participación

        // Verifica que se haya seleccionado un profesor y una fecha de participación
        if (profesorId && fechaParticipacion) {
            // Crea un nuevo elemento de lista (<li>) para mostrar el profesor y la fecha seleccionados
            const li = document.createElement('li');
            li.classList.add('list-group-item'); // Agrega una clase para el estilo
            li.innerHTML = `
                ${profesorNombre} - ${fechaParticipacion}
                <input type="hidden" name="profesores[]" value="${profesorId}"> <!-- Campo oculto para enviar el id del profesor -->
                <input type="hidden" name="fechasParticipacion[${profesorId}]" value="${fechaParticipacion}"> <!-- Campo oculto para enviar la fecha de participación -->
                <button type="button" class="btn btn-danger btn-sm float-right" onclick="eliminarProfesor(this)">Eliminar</button> <!-- Botón para eliminar este profesor de la lista -->
            `;
            document.getElementById('selectedProfesores').appendChild(li); // Agrega el nuevo elemento de lista al contenedor de profesores seleccionados

            // Elimina el profesor seleccionado del menú desplegable
            selectProfesor.remove(selectProfesor.selectedIndex);

            // Limpia los campos después de agregar
            selectProfesor.value = '';
            document.getElementById('fechaParticipacion').value = '';
        } else {
            // Muestra una alerta si no se ha seleccionado un profesor o una fecha
            alert('Por favor, seleccione un profesor y una fecha de participación.');
        }
    }

    function eliminarProfesor(button) {
        // Encuentra el elemento de lista (<li>) que contiene el botón de eliminar que fue clicado
        const li = button.closest('li');
        const profesorId = li.querySelector('input[name="profesores[]"]').value; // Obtiene el id del profesor del campo oculto
        const profesorNombre = li.textContent.trim().split(' - ')[0]; // Obtiene el nombre del profesor del texto del elemento de lista

        // Crea una nueva opción para el select con el profesor eliminado
        const option = document.createElement('option');
        option.value = profesorId; // Establece el valor de la opción (id del profesor)
        option.text = profesorNombre; // Establece el texto de la opción (nombre del profesor)

        // Inserta la opción en el select de profesores en orden alfabético
        const selectProfesor = document.getElementById('profesor');
        const options = Array.from(selectProfesor.options); // Convierte las opciones del select a un array
        options.push(option); // Agrega la nueva opción al array
        options.sort((a, b) => a.text.localeCompare(b.text)); // Ordena las opciones alfabéticamente por el texto
        selectProfesor.innerHTML = ''; // Vacía las opciones actuales del select
        options.forEach(opt => selectProfesor.appendChild(opt)); // Agrega las opciones ordenadas de nuevo al select

        // Elimina el elemento de la lista de profesores seleccionados
        li.remove();
    }
</script>
@endsection
<!-- Fin de la sección "content" -->
