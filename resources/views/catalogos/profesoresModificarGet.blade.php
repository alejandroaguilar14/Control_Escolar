@extends('components.layout')

@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: 2px solid #6c757d;
        padding: 10px;
    }

    .form-control:focus {
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

    h1 {
        color: white;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h1 class="mb-0 text-center">Modificar datos del profesor</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/catalogos/profesores/' . $profesor->idProfesor . '/modificar') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre" class="input-label">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control input-style" value="{{ $profesor->nombre }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="primerApellido" class="input-label">Primer Apellido:</label>
                            <input type="text" name="primerApellido" id="primerApellido" class="form-control input-style" value="{{ $profesor->primerApellido }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="segundoApellido" class="input-label">Segundo Apellido:</label>
                            <input type="text" name="segundoApellido" id="segundoApellido" class="form-control input-style" value="{{ $profesor->segundoApellido }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="NIF" class="input-label">NIF:</label>
                            <input type="text" name="NIF" id="NIF" class="form-control input-style" value="{{ $profesor->NIF }}" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);" autofocus>
                        </div>
                        <div class="row justify-content-center">
                        <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href='{{ url("/catalogos/profesores") }}' class="btn btn-dark">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
