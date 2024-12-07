<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Importar librerías de estilos y JavaScript de DataTables para manipular desde el navegador del usuario -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High School Karasuro</title>

    <style>
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 10px 20px;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .header .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .header .menu {
            display: flex;
            align-items: center;
        }

        .header .menu .nav-link {
            color: #fff;
            margin-right: 20px;
            padding: 8px 15px;
            text-decoration: none;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body>
    <!-- Header principal -->
    <div class="header">
        <a href="{{url('/home')}}" class="logo">High School Karasuro</a>
        <div class="menu">
        <a href="{{url('/catalogos/grupos')}}" class="nav-link">Grupos</a>
            <a href="{{url('/catalogos/alumnos')}}" class="nav-link">Alumnos</a>
            <a href="{{url('/catalogos/profesores')}}" class="nav-link">Profesores</a>
            <a href="{{url('/catalogos/examenpractico')}}" class="nav-link">Examen Práctico</a>
            <a href="{{url('/catalogos/examenteorico')}}" class="nav-link">Examen Teórico</a>
            <a href="{{url('/movimientos/evaluaciones')}}" class="nav-link">Evaluaciones</a>
            <a href="{{url('/reportes')}}" class="nav-link">Reportes</a>
            <a href="{{url('/logout')}}" class="nav-link">Salir</a>
        </div>
    </div>

  

    <div class="container" style="margin-top: 70px;"> <!-- Añadir margen superior para evitar que el contenido quede oculto detrás de los headers -->
        <!-- Contenido principal -->
        @section("content")
        @show
    </div>
</body>
</html>