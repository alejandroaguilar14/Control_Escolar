@extends('components.layout')
@section('content')
    @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endcomponent
    <style>
        h1 {
            color: #333;
            font-size: 32px;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-menu {
            display: inline-block;
            background-color: black;
            color: #fff;
            text-decoration: none;
            font-size: 24px; /* Aumentamos el tamaño de fuente */
            padding: 20px 40px; /* Aumentamos el padding */
            border-radius: 10px; /* Aumentamos el radio del borde */
            transition: background-color 0.3s;
            margin: 0 auto; /* Centramos los botones horizontalmente */
            display: block; /* Convertimos los botones en bloques para que ocupen toda la anchura */
            text-align: center; /* Centramos el texto */
            width: fit-content; /* Ajustamos el ancho al contenido */
        }

        .btn-menu:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="row my-4">
        <div class="col">
            <h1>Reportes</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('/reportes/notas')}}" class="btn-menu">Calificaciones</a>
            </div>
            <div class="col-md-6">
                <a href="{{url('/reportes/examenes')}}" class="btn-menu">Exámenes</a>
            </div>
        </div>
    </div>
@endsection