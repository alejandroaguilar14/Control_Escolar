<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de evaluaciones</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: 100vh;
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
                width: 100%; /* Ajusta esto según el ancho deseado para tu tabla */
                max-width: 800px; /* O un valor específico que prefieras */
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                text-align: center;
                padding: 8px;
            }
            th {
                background-color: #333; /* Un gris oscuro para los encabezados */
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            tr:hover {
                background-color: #ddd;
            }
            .img-container {
                margin-top: 20px;
                width: 100%; /* O ajusta según la necesidad */
                display: flex;
                justify-content: center;
            }
            img {
                max-width: 100%; /* Para asegurar que la imagen no exceda el ancho del contenedor */
                height: auto;
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
                    <th scope="col">Examen</th>
                    <th scope="col">Total de alumnos</th>
                    <th scope="col">Porcentaje de aprobados</th>
                    <th scope="col">Porcentaje de reprobados</th>
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
    </body>
</html>
