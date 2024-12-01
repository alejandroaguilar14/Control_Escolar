<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #AED6F1; /* Fondo azul pastel */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 350px;
            background: #FFFFFF; /* Fondo blanco para el contenedor de login */
        }
        .logo img {
            width: 120px;
            margin: 20px 0;
        }
        .card {
            background: white;
            width: 100%;
            padding: 20px;
        }
        .card-header {
            background-color: #3498DB; /* Tono azul más oscuro para la cabecera */
            color: white;
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
        }
        .btn-primary {
            background-color: #3498DB; /* Color azul para el botón */
            border-color: #1A5276; /* Bordes más oscuros para el botón */
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 15px;
        }
        .btn-primary:hover {
            background-color: #1A5276; /* Oscurecer el botón al pasar el mouse */
            border-color: #154360;
        }
        .card-footer {
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
        }
        .card-footer a {
            color: #3498DB; /* Color azul para enlaces */
        }
        .card-footer a:hover {
            text-decoration: none;
            color: #1A5276; /* Color más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="\imagenes\LogoKarasuro.png" alt="logo">
        </div>
        <div class="card">
            <div class="card-header text-center">Gestión de evaluaciones</div>
            <div class="card-body">
                <form method="POST" action='{{url("/login")}}'>
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo:</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
            <div class="card-footer">
                <small>¿No tienes una cuenta? <a href='{{url("/registrar")}}'>Regístrate aquí</a></small>
            
        </div>
    </div>
</body>
</html>