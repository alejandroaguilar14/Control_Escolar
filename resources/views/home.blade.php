@extends('components.layout')
@section('content')

    <style>
        h1 {
            color: #333;
            font-size: 72px;
            text-align: center;
            margin-bottom: 25px;
        }

        .welcome-message {
            font-size: 24px;
            text-align: center;
            margin-bottom: 75px;
        }

        .image-container {
            text-align: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>

    <div class="row my-4">
        <div class="col">
            <h1>Bienvenido al Sistema</h1>
            <p class="welcome-message">¡Gracias por unirte! Esperamos que disfrutes de nuestra plataforma.</p>
            <div class="image-container">
                <img src="Imagenes\LogoKarasuro.png" alt="Imagen de bienvenida" width="500" height="500">
            </div>
        </div>
    </div>
@endsection
