<?php

namespace App\Http\Controllers;
use App\Models\Grupo;
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

class MovimientosController extends Controller
{
    // Vista de inicio 
    public function home():View
    {
        return view('home',["breadcrumbs"=>[]]);
    }
/* --------------------------------------------- FUNCIONES PARA EVALUACIONES --------------------------------------------- */

    // Mostrar las evaluaciones habilitadas
    public function evaluacionesGet(): View 
    {
        // te traes la lista de evaluaciones habilitadas esto porque usamos la misma vista
        $evaluaciones = Evaluacion::with('grupo')->where('estado', 1)->get();

        // validacion para traer el examen correcto ya que guardamos los id de las dos tablas de examenes en un solo campo 
        foreach ($evaluaciones as $evaluacion) {
            if ($evaluacion->tipoExamen === 'TEORICO') {
                $examen = ExamenTeorico::find($evaluacion->idExamen);
            } elseif ($evaluacion->tipoExamen === 'PRACTICO') {
                $examen = ExamenPractico::find($evaluacion->idExamen);
            } else {
                $examen = null;
            }
            $evaluacion->nombreExamen = $examen ? $examen->titulo : 'Desconocido';
        }
        return view('movimientos/evaluacionesGet', [
            'evaluaciones' => $evaluaciones,
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Evaluaciones" => url("/movimientos/evaluaciones")
            ],
            'estado' => 1
        ]);
    }
    
    // Mostrar las evaluaciones deshabilitadas
    public function evaluacionesDeshabilitadasGet(): View 
    {
        $evaluaciones = Evaluacion::with('grupo')->where('estado', 0)->paginate(10);
        foreach ($evaluaciones as $evaluacion) {
            if ($evaluacion->tipoExamen === 'TEORICO') {
                $examen = ExamenTeorico::find($evaluacion->idExamen);
            } elseif ($evaluacion->tipoExamen === 'PRACTICO') {
                $examen = ExamenPractico::find($evaluacion->idExamen);
            } else {
                $examen = null;
            }
            $evaluacion->nombreExamen = $examen ? $examen->titulo : 'Desconocido';
        }
        return view('movimientos/evaluacionesGet', [
            'evaluaciones' => $evaluaciones,
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Evaluaciones Deshabilitadas" => url("/movimientos/evaluaciones/deshabilitadas")
            ],
            'estado' => 0
        ]);
    }    

    // Deshabilitar una evaluación
    public function deshabilitarEvaluacion($idEvaluacion) 
    {
        $evaluacion = Evaluacion::findOrFail($idEvaluacion);
        $evaluacion->estado = 0;
        $evaluacion->save();

        return redirect('/movimientos/evaluaciones')->with('status', 'Evaluación deshabilitada con éxito.');
    }

    // Habilitar una evaluacion seleccionada
    public function habilitarEvaluacion($idEvaluacion) 
    {
        $evaluacion = Evaluacion::findOrFail($idEvaluacion);
        $evaluacion->estado = 1;
        $evaluacion->save();

        return redirect('/movimientos/evaluaciones/deshabilitadas')->with('status', 'Evaluación habilitada con éxito.');
    }

    // Mostrar la lista de alumnos correspondientes a una evaluacion para asignar calificaciones
    public function mostrarCalificaciones($idEvaluacion)
    {
        $evaluacion = Evaluacion::with('grupo')->findOrFail($idEvaluacion);
        
        // Obtiene el examen asociado (practico o teorico)
        $examen = $evaluacion->tipoExamen == 'Practico' 
                ? ExamenPractico::findOrFail($evaluacion->idExamen) 
                : ExamenTeorico::findOrFail($evaluacion->idExamen);
        
        // Obtiene los alumnos del grupo
        $alumnos = Alumno::where('fk_idGrupo', $evaluacion->fk_idGrupo)->get();
        
        // Obtiene las calificaciones existentes
        $calificaciones = Detalle_Evaluacion_Alumno::where('fk_idEvaluacion', $idEvaluacion)->get()->keyBy('fk_idAlumno');
        
        return view('movimientos/calificacionesGet', compact('evaluacion', 'examen', 'alumnos', 'calificaciones'));
    }

    // Guardamos o actualizamos las calificaciones
    public function guardarCalificaciones(Request $request, $idEvaluacion)
    {
        $evaluacion = Evaluacion::findOrFail($idEvaluacion);
        $calificaciones = $request->input('calificaciones');
        
        foreach ($calificaciones as $idAlumno => $nota) {
            $detalle = Detalle_Evaluacion_Alumno::firstOrNew([
                'fk_idEvaluacion' => $idEvaluacion,
                'fk_idAlumno' => $idAlumno,
            ]);
            $detalle->nota = $nota;
            $detalle->save();
        }

        return redirect('/movimientos/evaluaciones')->with('status', 'Calificaciones Guardadas con Exito');

    }


    // Mostamos las evaluaciones de los dos tipos de examen de un alumno en especifico

    public function alumnosEvaluacionesGet(Request $request, $idAlumno)
    {
        $evaluacionesPractico = Evaluacion::join("examenpractico", "examenpractico.idExamenPractico", "=", "evaluacion.idExamen")
        ->join("detalle_evaluacion_alumno", "detalle_evaluacion_alumno.fk_idEvaluacion", "=", "evaluacion.idEvaluacion")
        ->select("evaluacion.*", "examenpractico.titulo as examPractico","detalle_evaluacion_alumno.nota as nota")
        ->where("detalle_evaluacion_alumno.fk_idAlumno", "=", $idAlumno)
        ->where("evaluacion.tipoExamen", "=", "PRACTICO")
        ->get();

        $evaluacionesTeorico = Evaluacion::join("examenteorico", "examenteorico.idExamenTeorico", "=", "evaluacion.idExamen")
        ->join("detalle_evaluacion_alumno", "detalle_evaluacion_alumno.fk_idEvaluacion", "=", "evaluacion.idEvaluacion")
        ->select("evaluacion.*", "examenteorico.titulo as examTeorico","detalle_evaluacion_alumno.nota as nota")
        ->where("detalle_evaluacion_alumno.fk_idAlumno", "=", $idAlumno)
        ->where("evaluacion.tipoExamen", "=", "TEORICO")
        ->get();

        $alumnos = Alumno::find($idAlumno);
        return view('movimientos/alumnosEvaluacionesGet', [
            'evaluacionesTeorico'=> $evaluacionesTeorico,
            'evaluacionesPractico'=> $evaluacionesPractico,
            'alumnos' => $alumnos,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Alumnos"=>url("/catalogos/alumnos"),
                "Evaluaciones"=>url("/movimientos/alumnos/{id}/evaluaciones")
            ]
        ]);
    }

    // Programamos una nueva evaluacion 
    public function agregarEvaluacion()
    {
        $grupos = Grupo::all();
        $examenesTeoricos = ExamenTeorico::all();
        $examenesPracticos = ExamenPractico::all();
        return view('movimientos/evaluacionesAgregarGet', compact('grupos', 'examenesTeoricos', 'examenesPracticos'));
    }

    // Guardamos la evaluacion 
    public function guardarEvaluacion(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'tipoExamen' => 'required|in:TEORICO,PRACTICO',
            'idExamen' => 'required|integer',
            'grupo' => 'required|integer'
        ]);

        $evaluacion = new Evaluacion();
        $evaluacion->fecha = $request->fecha;
        $evaluacion->idExamen = $request->idExamen;
        $evaluacion->tipoExamen = $request->tipoExamen;
        $evaluacion->fk_idGrupo = $request->grupo; 
        $evaluacion->estado = 1; //se guarda el estado en 1 sin que el usuario lo tenga que ingresar

        $evaluacion->save();

        return redirect('movimientos/evaluaciones')->with('success', 'Evaluación guardada correctamente.');
    }

    // Editamos la fecha de la evaluacion seleccionada 
    public function editarEvaluacion($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $grupos = Grupo::all();
        $examenesTeoricos = ExamenTeorico::all();
        $examenesPracticos = ExamenPractico::all();

        // Determinar el título del examen basado en el tipo de examen
        if ($evaluacion->tipoExamen == 'TEORICO') {
            $examenTitulo = ExamenTeorico::find($evaluacion->idExamen)->titulo;
        } else {
            $examenTitulo = ExamenPractico::find($evaluacion->idExamen)->titulo;
        }

        return view('movimientos/evaluacionesModificarGet', compact('evaluacion', 'grupos', 'examenesTeoricos', 'examenesPracticos', 'examenTitulo'));
    }


    // Actualizamos
    public function actualizarEvaluacion(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $evaluacion = Evaluacion::findOrFail($id);
        $evaluacion->fecha = $request->fecha;
        $evaluacion->save();

        return redirect('movimientos/evaluaciones')->with('success', 'Evaluación guardada correctamente.');
    }

}
