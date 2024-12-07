@extends("components.layout")

@section("content")
<div class="container">
    <!-- Título del examen y grupo -->
    <div class="my-4">
        <h1>{{ $examen->titulo }}</h1>
        <h2>Grupo: {{ $evaluacion->grupo->nombre }}</h2>
    </div>
    <!-- Formulario para ingresar las calificaciones -->
    <form action="{{ url('/movimientos/evaluaciones/'.$evaluacion->idEvaluacion.'/calificaciones') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <!-- Bucle para mostrar cada alumno y su campo de calificación -->
                @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->nombre }} {{ $alumno->primerApellido }} {{ $alumno->segundoApellido }}</td>
                    <td>
                        <!-- Campo de entrada de calificación -->
                        <input type="number" name="calificaciones[{{ $alumno->idAlumno }}]" min="1" max="100" required class="form-control"
                               value="{{ isset($calificaciones[$alumno->idAlumno]) ? $calificaciones[$alumno->idAlumno]->nota : '' }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Botón para guardar las calificaciones -->
        <button type="submit" class="btn btn-primary">Guardar Calificaciones</button>
    </form>
</div>

@endsection

@section('styles')
<style>
    .container {
        max-width: 800px;
    }
    h1, h2 {
        text-align: center;
    }
    table {
        width: 100%;
    }
</style>
@endsection