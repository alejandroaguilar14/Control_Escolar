<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de evaluaciones: {{$examen->titulo}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
        }
        table {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Preparatoria Karasuro</h1>
        <h2 class="report-title">Reporte de evaluaciones: {{$examen->titulo}}</h2>
        <div>
        <p><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($datos['fechaIn'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($datos['fechaFin'])->format('d/m/Y') }}</p>
            <p><strong>Fecha de elaboración del reporte:</strong> {{\Carbon\Carbon::now()->toDateString()}}</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>FECHA</th>
                <th>ALUMNO</th>
                <th>NOTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluaciones as $evaluacion) 
                <tr>
                    <td>{{$evaluacion->fecha}}</td>
                    <td>{{$evaluacion->nombreAlumno}}</td>
                    <td>{{$evaluacion->nota}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
