<?php

namespace App\Http\Controllers;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\ExamenPractico;
use App\Models\ExamenTeorico;
use App\Models\Detalle_Profesor_ExamPractico;
use App\Models\Evaluacion;
use App\Models\Detalle_Evaluacion_Alumno;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use PDF;
use Illuminate\Support\Facades\Storage;

class ReportesController extends Controller{
/* --------------------------------------------- INDICE DE REPORTES --------------------------------------------- */

public function home():View
{
        return view('home',["breadcrumbs"=>[]]);  
    }

    public function indexGet(Request $request){
        return view("reportes/indexGet",[
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Reportes"=>url("/reportes")
            ]
        ]);
    }
/* -------------------------------------------------------------------------------------------------------------- */


/* -------------------------------------- REPORTE DEL HISTORICO DE EVALUACIONES DE UN EXAMEN -------------------------------------- */

    public function notasGet(Request $request)
    {
        // Datos necesarios para hacer el filtro 
        $examenesPracticos = ExamenPractico::all();
        $examenesTeoricos = ExamenTeorico::all();
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        $evaluaciones = Evaluacion::join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->join('alumno', 'alumno.idAlumno', '=', 'detalle_evaluacion_alumno.fk_idAlumno')
        ->select('evaluacion.fecha', 'detalle_evaluacion_alumno.nota', 'evaluacion.tipoExamen', DB::raw("CONCAT(alumno.nombre, ' ', alumno.primerApellido, ' ', alumno.segundoApellido) AS nombreAlumno"))
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->get();
        
        return view("reportes/notasGet",[
            "examenesTeoricos"=>$examenesTeoricos,
            "examenesPracticos"=>$examenesPracticos,
            "evaluaciones"=>$evaluaciones,
            "examen"=>$examen,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Reportes"=>url("/reportes"),
                "Evaluaciones"=>url("/reportes/notas")
            ]
        ]);
    }

    // Vizualizar pdf 
    public function notaspdfGet(Request $request)
    {
        //recibimos los parametros para filtrar la consulta 
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        //enviamos los datos del periodo para que se puedan vizualizar en el pdf
        $datos = ['fechaIn' => $fechaIn, 'fechaFin' => $fechaFin];
        $evaluaciones = Evaluacion::join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->join('alumno', 'alumno.idAlumno', '=', 'detalle_evaluacion_alumno.fk_idAlumno')
        ->select('evaluacion.fecha', 'detalle_evaluacion_alumno.nota', 'evaluacion.tipoExamen', DB::raw("CONCAT(alumno.nombre, ' ', alumno.primerApellido, ' ', alumno.segundoApellido) AS nombreAlumno"))
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->get();
        $pdf = PDF::loadView('/reportes/notaspdfGet',['evaluaciones'=>$evaluaciones,'examen'=>$examen,'datos'=>$datos]);
        return $pdf->stream();
    }

    //descargar el pdf
    public function notasdownloadpdfGet(Request $request)
    {
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        $datos = ['fechaIn' => $fechaIn, 'fechaFin' => $fechaFin];
        $evaluaciones = Evaluacion::join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->join('alumno', 'alumno.idAlumno', '=', 'detalle_evaluacion_alumno.fk_idAlumno')
        ->select('evaluacion.fecha', 'detalle_evaluacion_alumno.nota', 'evaluacion.tipoExamen', DB::raw("CONCAT(alumno.nombre, ' ', alumno.primerApellido, ' ', alumno.segundoApellido) AS nombreAlumno"))
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->get();
        $pdf = PDF::loadView('/reportes/notaspdfGet',['evaluaciones'=>$evaluaciones,'examen'=>$examen,'datos'=>$datos]);
        return $pdf->download('evaluaciones.pdf');
    }


/* -------------------------------------------------------------------------------------------------------------------------------- */

/* -------------------------------------- REPORTE DE PORCENTAJE DE APROBADOS Y REPROBADOS -------------------------------------- */

    public function examenesGet(Request $request){
        // Datos necesarios para hacer el filtro 
        $examenesPracticos = ExamenPractico::all();
        $examenesTeoricos = ExamenTeorico::all();
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        // trae el porcentaje de aprobados y reprobados de un examen en un rango de fechas especifico
        $evaluaciones = Evaluacion::join('examenpractico', 'evaluacion.idExamen', '=', 'examenpractico.idExamenPractico')
        ->join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->leftJoin('examenteorico', 'evaluacion.idExamen', '=', 'examenteorico.idExamenTeorico')
        ->selectRaw("
            CASE 
                WHEN evaluacion.tipoExamen = 'PRACTICO' THEN examenpractico.titulo
                ELSE examenteorico.titulo
            END AS 'TituloExam',
            COUNT(evaluacion.idEvaluacion) as 'TotalAlumnos',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota >= 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeAprobados',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota < 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeReprobados'
        ")
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->groupBy('TituloExam')
        ->get();
        return view("reportes/examenesGet",[
            "evaluaciones"=>$evaluaciones,
            "examenesTeoricos"=>$examenesTeoricos,
            "examenesPracticos"=>$examenesPracticos,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Reportes"=>url("/reportes"),
                "Examenes"=>url("/reportes/examenes")
            ]
        ]);
    }

    // visualizar el pdf
    public function examenespdfGet(Request $request){
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        $datos = ['fechaIn' => $fechaIn, 'fechaFin' => $fechaFin];
        $evaluaciones = Evaluacion::join('examenpractico', 'evaluacion.idExamen', '=', 'examenpractico.idExamenPractico')
        ->join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->leftJoin('examenteorico', 'evaluacion.idExamen', '=', 'examenteorico.idExamenTeorico')
        ->selectRaw("
            CASE 
                WHEN evaluacion.tipoExamen = 'PRACTICO' THEN examenpractico.titulo
                ELSE examenteorico.titulo
            END AS 'TituloExam',
            COUNT(evaluacion.idEvaluacion) as 'TotalAlumnos',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota >= 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeAprobados',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota < 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeReprobados'
        ")
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->groupBy('TituloExam')
        ->get();
        $pdf = PDF::loadView('/reportes/examenespdfGet',['evaluaciones'=>$evaluaciones,'examen'=>$examen,'datos'=>$datos]);
        return $pdf->stream();
    }

    //descargar el pdf
    public function examenesdownloadpdfGet(Request $request){
        $fechaIn = Carbon::now()->format("Y-m-d");
        $fechaIn = $request->query("fechaIn", $fechaIn);
        if (empty($request->fechaFin)) {
            $fechaFin = $fechaIn;
        }else{ 
            $fechaFin = Carbon::now()->format("Y-m-d");
            $fechaFin = $request->query("fechaFin", $fechaFin);
        }
        $idExamen=$request->input("idExamen");
        $tipoExamen=$request->input("tipoExamen");
        if ($tipoExamen === 'PRACTICO') {
            $examen = ExamenPractico::find($idExamen);
        } else {    
            $examen = ExamenTeorico::find($idExamen);
        }
        $datos = ['fechaIn' => $fechaIn, 'fechaFin' => $fechaFin];
        $evaluaciones = Evaluacion::join('examenpractico', 'evaluacion.idExamen', '=', 'examenpractico.idExamenPractico')
        ->join('detalle_evaluacion_alumno', 'evaluacion.idEvaluacion', '=', 'detalle_evaluacion_alumno.fk_idEvaluacion')
        ->leftJoin('examenteorico', 'evaluacion.idExamen', '=', 'examenteorico.idExamenTeorico')
        ->selectRaw("
            CASE 
                WHEN evaluacion.tipoExamen = 'PRACTICO' THEN examenpractico.titulo
                ELSE examenteorico.titulo
            END AS 'TituloExam',
            COUNT(evaluacion.idEvaluacion) as 'TotalAlumnos',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota >= 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeAprobados',
            (SUM(CASE WHEN detalle_evaluacion_alumno.nota < 60 THEN 1 ELSE 0 END) / COUNT(detalle_evaluacion_alumno.id_det_eva_alum)) * 100 as 'PorcentajeReprobados'
        ")
        ->where("evaluacion.tipoExamen","=",$tipoExamen)
        ->where("evaluacion.idExamen","=", $idExamen)
        ->where("evaluacion.fecha",">=",$fechaIn)
        ->where("evaluacion.fecha","<=",$fechaFin)
        ->groupBy('TituloExam')
        ->get();
        $pdf = PDF::loadView('/reportes/examenespdfGet',['evaluaciones'=>$evaluaciones,'examen'=>$examen,'datos'=>$datos]);
        return $pdf->download('evaluaciones.pdf');
    }


    // intento de que se viera la imagen en el pdf, no funciona 
    public function guardarImagen(Request $request){
        $image = $request->image; // La imagen en base64
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'grafica.png'; // Nombre fijo para reemplazar siempre la misma imagen

        Storage::disk('public')->put($imageName, base64_decode($image));

        return response()->json(['success' => 'Imagen guardada correctamente']);
    }
/* ----------------------------------------------------------------------------------------------------------------------------- */

    


}
