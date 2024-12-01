<?php

namespace App\Http\Controllers;
use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\ExamenPractico;
use App\Models\ExamenTeorico;
use App\Models\Detalle_Profesor_ExamPractico;
use App\Models\Evaluacion;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CatalogosController extends Controller{

/* --------------------------------------------- FUNCIONES PARA EL INICIO Y SALIDA --------------------------------------------- */

    // Home
    public function inicio():View
    {
        return view('home', ["breadcrumbs"=>[]]);
    }
    // Login
    public function home():View
    {
        return view('login');
    }
    // Función para logear
    public function login(Request $request)
    {
        $credenciales=[
            "email" => $request->email,
            "password" => $request->password
        ];
        $remeber = ($request->has('remeber')? true : false);
        if(Auth::attempt($credenciales,$remeber)){
            $request->session();
            return redirect("/home");
        }else{
            return redirect("/");
        }
    }
    // Función para mostrar la salida
    public function logout(Request $request)
    {
        Auth::logout();
        $request ->session()->invalidate();
        $request -> session();
        return redirect("/");
    }
    // Función para registrarse
    public function registrar():View
    {
        return view('logon');
    }
    public function register(Request $request)
    {
       $user = new User();
       $user -> name=$request->name;
       $user -> email=$request->email;
       $user -> password=($request->password);

       $user -> save();

       Auth::login($user);
       return redirect("/home");
    }
/* ----------------------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------- FUNCIONES PARA LOS GRUPOS --------------------------------------------- */

    // Mostrar grupos activos
    public function gruposGet(): View {
        //Traes todos los grupos activos de la base
        $grupos = Grupo::where('estado', 1)->paginate(10);
        return view('catalogos/gruposGet', [
            'grupos' => $grupos,
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Grupos" => url("/catalogos/grupos")
            ],
            //le pasas el estado en 1 porque estas usando la misma vista para los activos y deshabilitados
            'estado' => 1
        ]);
    }

    // Mostrar grupos deshabilitados
    public function gruposDeshabilitadosGet(): View {
        //Traes todos los grupos deshabilitados de la base
        $grupos = Grupo::where('estado', 0)->paginate(10);
        return view('catalogos/gruposGet', [
            'grupos' => $grupos,
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Grupos Deshabilitados" => url("/catalogos/grupos/deshabilitados")
            ],
            //le pasas el estado en 0 porque estas usando la misma vista para los activos y deshabilitados
            'estado' => 0
        ]);
    }

    // Deshabilitar grupo
    public function deshabilitarGrupo($idGrupo) {
        $grupo = Grupo::findOrFail($idGrupo);
        $grupo->estado = 0;
        $grupo->save();
        return redirect('/catalogos/grupos')->with('status', 'Grupo deshabilitado con éxito.');
    }

    // Habilitar grupo
    public function habilitarGrupo($idGrupo) {
        $grupo = Grupo::findOrFail($idGrupo);
        $grupo->estado = 1;
        $grupo->save();

        return redirect('/catalogos/grupos/deshabilitados')->with('status', 'Grupo habilitado con éxito.');
    }

    // Funciones para agregar un grupo
    public function mostrarFormularioAgregar()
    {
        return view('catalogos/gruposAgregarGet');
    }

    public function agregarGrupo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:1|regex:/^[A-Za-z]$/',
            'semestre' => 'required|integer|between:1,6'
        ]);
    
        Grupo::create([
            'nombre' => strtoupper($request->nombre), 
            'semestre' => $request->semestre,
            'estado' => 1 // Establecer el estado a 1 (activo) por defecto ya que el usuario no ingresa el estado 
        ]);

        return redirect('catalogos/grupos')->with('success', 'Grupo agregado correctamente.');
    }

    // Funciones para modificar un grupo
    public function mostrarFormularioModificar($id)
    {
        $grupo = Grupo::findOrFail($id);
        return view('catalogos/gruposModificarGet', compact('grupo'));
    }

    public function modificarGrupo(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:1|regex:/^[A-Za-z]$/',
            'semestre' => 'required|integer|between:1,6'
        ]);

        $grupo = Grupo::findOrFail($id);
        $grupo->nombre = strtoupper($request->nombre); // Convertir a mayúsculas
        $grupo->semestre = $request->semestre;
        $grupo->save();

        return redirect('/catalogos/grupos')->with('success', 'Grupo modificado correctamente.');
    }

/* --------------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------- FUNCIONES PARA LOS ALUMNOS --------------------------------------------- */

    // Mostrar alumnos activos
    public function alumnosGet(Request $request): View
    {
        
        $alumnos = Alumno::join('grupo', 'alumno.fk_idGrupo', '=', 'grupo.idGrupo')
        ->select('alumno.*', DB::raw("CONCAT(grupo.semestre, '-', grupo.nombre) AS grupo"))
        ->where('alumno.estado', 1)
        ->get();
        return view('catalogos.alumnosGet', [
            'alumnos' => $alumnos,
            'breadcrumbs' => [
                'Inicio' => url('/home'),
                'Alumnos' => url('/catalogos/alumnos')
            ]
        ]);
    }

    // Dar de baja a un alumno
    public function alumnosDelete($idAlumno)
    {
        $alumnoEliminar = Alumno::findOrFail($idAlumno);
        $alumnoEliminar -> estado = 0;
        $alumnoEliminar->save();

        return redirect()->back()->with('success', 'Alumno dado de baja con éxito.');
    } 

    // Mostrar alumnos dados de baja
    public function alumnosEliminados(): View
    {
        $alumnosInactivos = Alumno::join('grupo', 'alumno.fk_idGrupo', '=', 'grupo.idGrupo')
        ->select('alumno.*', DB::raw("CONCAT(grupo.semestre, '-', grupo.nombre) AS grupo"))
        ->where('alumno.estado', 0)
        ->get();

        return view('catalogos/alumnosEliminados', [
            "alumnosInactivos" => $alumnosInactivos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Alumnos" => url("/catalogos/alumnos"),
                "Suspendidos" => url("/catalogos/alumnos/eliminados")
            ]
        ]);
    }

    // Activar a un alumno
    public function alumnoActivar($idAlumno)
    {
        $alumnoActivar = Alumno::findOrFail($idAlumno);
        $alumnoActivar -> estado = 1;
        $alumnoActivar -> save();
  
        return redirect()->back()->with('success', 'Alumno reactivado con éxito.');
    }

    // Agragar a un alumno nuevo
    public function alumnosAgregarGet(): View
    {
        // trae de la base todos los grupos activos
        $grupos = Grupo::select(
            'grupo.idGrupo', 
            DB::raw("CONCAT(grupo.semestre, '-', grupo.nombre) AS grupo")
        )->where("grupo.estado",1)->get();
         
        return view('catalogos/alumnosAgregarGet',[
            "grupos"=>$grupos,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Alumnos"=>url("/catalogos/alumnos"),
                "Agregar"=>url("/catalogos/alumnos/agregar")
            ]
        ]);
    }

    // Guarda el nuevo registro del alumno
    public function alumnosAgregarPost(Request $request)
    {
        $nombre=$request->input("nombre");
        $primerApellido=$request->input("primerApellido");
        $segundoApellido=$request->input("segundoApellido");
        $NIF=$request->input("NIF");
        $grupo=$request->input("grupo");
        $estado=$request->input("estado");

        $alumnos=new Alumno([
            "nombre"=>strtoupper($nombre),
            "primerApellido"=>strtoupper($primerApellido),
            "segundoApellido"=>strtoupper($segundoApellido),
            "NIF"=>strtoupper($NIF),
            "fk_idGrupo"=>$grupo,
            "estado"=>$estado,
        ]);
        $alumnos->save();
        return redirect("/catalogos/alumnos"); 
    }

    // Modifica al alumno seleccionado
    public function alumnosModificarGet(Request $request, $idAlumno): View
    {
        $grupos = Grupo::select(
            'grupo.idGrupo', 
            DB::raw("CONCAT(grupo.semestre, '-', grupo.nombre) AS grupo")
        )->where("grupo.estado",1)->get();
        $alumno=Alumno::find($idAlumno);
        return view('/catalogos/alumnosModificarGet',[
            "alumno"=>$alumno,
            "grupos"=>$grupos,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Alumnos"=>url("/catalogos/alumnos"),
                "Modificar"=>url("/catalogos/alumnos/{$idAlumno}/modificar")
            ]
        ]);
    }

    // Guarda las modificaciones del alumno
    public function alumnosModificarPost(Request $request, $idAlumno)
    {
        $alumno=Alumno::find($idAlumno);
        $alumno->nombre=strtoupper($request->input("nombre"));
        $alumno->primerApellido=strtoupper($request->input("primerApellido"));
        $alumno->segundoApellido=strtoupper($request->input("segundoApellido"));
        $alumno->NIF=strtoupper($request->input("NIF"));
        $alumno->fk_idGrupo=strtoupper($request->input("grupo"));
        $alumno->save();
        return redirect("/catalogos/alumnos"); 
    }
/* ---------------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------- FUNCIONES PARA LOS PROFESORES --------------------------------------------- */

    // Mostrar lista de profesores activos
    public function profesoresGet(): View
    {
        // trae de la ase todos los profesores activos
        $profesores = Profesor::where('profesor.estado', 1)->get();
        return view('catalogos/profesoresGet', [
            'profesores' => $profesores,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Profesores"=>url("/catalogos/profesores")
            ]
        ]);
    }

    // Deshabilita a un profesor 
    public function profesoresDelete($idProfesor)
    {
        $profesorEliminar = Profesor::findOrFail($idProfesor);
        $profesorEliminar -> estado = 0;
        $profesorEliminar->save();

        return redirect()->back()->with('success', 'Profesor dado de baja con éxito.');
    } 

    // Mostrar profesores deshabilitados
    public function profesoresEliminados(): View
    {
        $profesoresInactivos = Profesor::where('profesor.estado', 0)->get();

        return view('catalogos/profesoresEliminados', [
            "profesoresInactivos" => $profesoresInactivos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Profesores" => url("/catalogos/profesores"),
                "Suspendidos" => url("/catalogos/profesores/eliminados")
            ]
        ]);
    }

    // Activar un profesor de la lista de profesores deshabilitados
    public function profesorActivar($idProfesor)
    {
        $profesorActivar = Profesor::findOrFail($idProfesor);
        $profesorActivar -> estado = 1;
        $profesorActivar -> save();
  
        return redirect()->back()->with('success', 'Profesor reactivado con éxito.');
    }

    // Agregar un profesor nuevo
    public function profesoresAgregarGet(): View
    {
        return view('catalogos/profesoresAgregarGet',[
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Profesores"=>url("/catalogos/profesores"),
                "Agregar"=>url("/catalogos/profesores/agregar")
            ]
        ]);
    }

    // Guardar al nuevo profesor
    public function profesoresAgregarPost(Request $request)
    {
        $nombre=$request->input("nombre");
        $primerApellido=$request->input("primerApellido");
        $segundoApellido=$request->input("segundoApellido");
        $NIF=$request->input("NIF");
        $estado=1;

        $profesor=new Profesor([
            "nombre"=>strtoupper($nombre),
            "primerApellido"=>strtoupper($primerApellido),
            "segundoApellido"=>strtoupper($segundoApellido),
            "NIF"=>strtoupper($NIF),
            "estado"=>$estado
            
        ]);
        $profesor->save();
        return redirect("/catalogos/profesores"); 
    }

    // Modificar a un profesor activo
    public function profesoresModificarGet(Request $request, $idProfesor): View
    {
        $profesor=Profesor::find($idProfesor);

        return view('/catalogos/profesoresModificarGet', [
            "profesor" => $profesor,
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Profesores" => url("/catalogos/profesores"),
                "Modificar" => url("/catalogos/profesores/{id}/modificar")
            ]
        ]);
    }

    // Guardar la modificación de un profesor
    public function profesoresModificarPost(Request $request, $idProfesor)
    {
        $profesor=Profesor::find($idProfesor);
        $profesor->nombre=strtoupper($request->input("nombre"));
        $profesor->primerApellido=strtoupper($request->input("primerApellido"));
        $profesor->segundoApellido=strtoupper($request->input("segundoApellido"));
        $profesor->NIF=strtoupper($request->input("NIF"));

        $profesor->save();

        return redirect("/catalogos/profesores");
    }

/* ------------------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------- FUNCIONES PARA LOS EXAMENES PRACTICOS --------------------------------------------- */

    // Mostrar los examenes prácticos
    public function examenpracticoGet(): View
    {
        $examenespracticos = ExamenPractico::get();
        return view('catalogos/examenpracticoGet', [
            'examenespracticos' => $examenespracticos,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Examen Práctico"=>url("/catalogos/examenpractico")
            ]
        ]);
    }

    // Agregar un exam práctico
    public function examenpracticoAgregarGet(): View
    {
        $profesores = Profesor::where('estado',1)->get();
        // Inicializar el array de profesores seleccionados para que los vaya tomando según se seleccionan
        $profesoresSeleccionados = Session::get('profesoresSeleccionados', []); 
        return view('catalogos/examenpracticoAgregarGet', [
            "profesores" => $profesores,
            "profesoresSeleccionados" => $profesoresSeleccionados, // Pasar la variable a la vista
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "Examen Práctico" => url("/catalogos/examenpractico"),
                "Agregar" => url("/catalogos/examenpractico/agregar")
            ]
        ]);
    }

    // Guardar el examen practico y los profesores participantes
    public function examenpracticoAgregarPost(Request $request)
    {
        $titulo = $request->input("titulo");
        $gradoDificultad = $request->input("gradoDificultad");
        $profesoresIds = $request->input("profesores", []);
        $fechasParticipacion = $request->input("fechasParticipacion", []);
        $estado = 1;
        // guardamos los datos en la tabla examen practico
        $examenPractico = new ExamenPractico([
            "titulo" => strtoupper($titulo),
            "gradoDificultad" => strtoupper($gradoDificultad),
            "estado" => $estado,
        ]);
        $examenPractico->save();

        // iteramos entre el array de profesores seleccionados y guardamos en la tabla detalle 
        foreach ($profesoresIds as $profesorId) {
            $fechaParticipacion = $fechasParticipacion[$profesorId] ?? null;

            $detalleProfesorExamPractico = new Detalle_Profesor_ExamPractico([
                "fechaParticipacion" => $fechaParticipacion,
                "fk_idProfesor" => $profesorId,
                "fk_idExamenPractico" => $examenPractico->idExamenPractico,
            ]);
            $detalleProfesorExamPractico->save();
        }

        return redirect("/catalogos/examenpractico");
    }

    // Modificamos un exámen práctico seleccionado
    public function examenpracticoModificarGet(Request $request, $idExamenPractico): View
    {
        $examPractico=ExamenPractico::find($idExamenPractico);
        return view('/catalogos/examenpracticoModificarGet',[
            "examPractico"=>$examPractico,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Examen Práctico"=>url("/catalogos/examenpractico"),
                "Modificar"=>url("/catalogos/examenpractico/{id}/modificar")
            ]
        ]);
    }

    // Guardar los datos modificados 
    public function examenpracticoModificarPost(Request $request, $idExamenPractico)
    {
        $examPractico=ExamenPractico::find($idExamenPractico);
        $examPractico->titulo=strtoupper($request->input("titulo"));
        $examPractico->gradoDificultad=$request->input("gradoDificultad");
        $examPractico->save();
        return redirect("/catalogos/examenpractico"); 
    }

    // Mostrar los profesores que han participado en un examen practico
    public function profesoresExamenesPracticosGet(Request $request, $idExamenPractico): View
    {
        // traemos todos los profesores participantes en el examen seleccionado
        $examenProfesores = Detalle_Profesor_ExamPractico::join("profesor","profesor.idProfesor","=","detalle_profesor_exampractico.fk_idProfesor")
        ->select("detalle_profesor_exampractico.*",DB::raw("CONCAT(profesor.nombre, ' ', profesor.primerApellido, ' ', profesor.segundoApellido) AS nombreCompleto"))
        ->where ("detalle_profesor_exampractico.fk_idExamenPractico","=",$idExamenPractico)
        ->get();
        // traemos los datos del examen practico seleccionado
        $examenpractico = ExamenPractico::find($idExamenPractico);
        return view('catalogos/profesoresExamenesPracticosGet',[
            "examenProfesores"=>$examenProfesores,
            "examenpractico"=>$examenpractico,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Examen Practico"=>url("/catalogos/examenpractico"),
                "Profesores"=>url("/catalogos/examenpractico/{id}/profesores")
            ]
        ]);
    }

    // Agregamos un nuevo profesor en un examen seleccionado
    public function profesoresExamenesPracticosAgregarGet(Request $request, $idExamenPractico): View{
        $examPractico=ExamenPractico::find($idExamenPractico);
        // traemos a los profesores que no han participado en dicho examen       
        $profesores = Profesor::select('profesor.*')
        ->leftJoin('detalle_profesor_examPractico', function($join) use ($idExamenPractico) {
            $join->on('profesor.idProfesor', '=', 'detalle_profesor_examPractico.fk_idProfesor')
                ->where('detalle_profesor_examPractico.fk_idExamenPractico', '=', $idExamenPractico);
        })
        ->whereNull('detalle_profesor_examPractico.fk_idProfesor')
        ->get();
        $profesoresSeleccionados = Session::get('profesoresSeleccionados', []);
        return view('/catalogos/profesoresExamenesPracticosAgregarGet',[
            "examPractico"=>$examPractico,
            "profesores"=>$profesores,
            "profesoresSeleccionados" => $profesoresSeleccionados, 
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "profesores"=>url("/catalogos/examenpractico/$idExamenPractico/profesores"),
                "Modificar"=>url("/catalogos/examenpractico/{id}/profesores/agregar")
            ]
        ]);
    }
    
    // Guardamos los nuevos profesores que participaron en el examen seleccionado
    public function profesoresExamenesPracticosAgregarPost(Request $request, $idExamenPractico)
    {
        $profesoresIds = $request->input("profesores", []);
        $fechasParticipacion = $request->input("fechasParticipacion", []);

        foreach ($profesoresIds as $profesorId) {
            $fechaParticipacion = $fechasParticipacion[$profesorId] ?? null;

            $detalleProfesorExamPractico = new Detalle_Profesor_ExamPractico([
                "fechaParticipacion" => $fechaParticipacion,
                "fk_idProfesor" => $profesorId,
                "fk_idExamenPractico" => $idExamenPractico,
            ]);
            $detalleProfesorExamPractico->save();
        }
        return redirect("/catalogos/examenpractico/{$idExamenPractico}/profesores"); 
    }

    // Modificamos la ultima fecha de participación de un profesor en el examen seleccionado 
    public function profesoresExamenesPracticosModificarGet(Request $request, $id_det_prof_examPractico): View
    {
        $detalle=Detalle_Profesor_ExamPractico::find($id_det_prof_examPractico);       
        $profesor=Profesor::find($detalle->fk_idProfesor);
        return view('/catalogos/profesoresExamenesPracticosModificarGet',[
            "detalle"=>$detalle,
            "profesor"=>$profesor,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "profesores"=>url("/catalogos/examenpractico/{$detalle->fk_idExamenPractico}/profesores"),
                "Modificar"=>url("/catalogos/examenpractico/{id}/profesores/modificar")
            ]
        ]);
    }

    // Guardamos la fecha de participación
    public function profesoresExamenesPracticosModificarPost(Request $request, $id_det_prof_examPractico)
    {
        $detalle=Detalle_Profesor_ExamPractico::find($id_det_prof_examPractico);
        $detalle->fechaParticipacion=$request->input("fechaParticipacion");
        $detalle->save();
        return redirect("/catalogos/examenpractico/{$detalle->fk_idExamenPractico}/profesores"); 
    }




/* --------------------------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------- FUNCIONES PARA LOS EXAMENES TEORICOS --------------------------------------------- */


    // Mostrar la lista de examenes teoricos
    public function examenteoricoGet(): View
    {
        #---ExamenTeorico::join Utiliza el modelo ExamenTeorico para realizar una operación de unión JOIN con la tabla profesor----#
        #Especifica cómo se hará la unión entre las tablas, esto permite acceder a los datos del profesor relacionado con cada ExamenTeorico---#
        $examenesteoricos = ExamenTeorico::join('profesor', 'examenteorico.fk_idProfesor', '=', 'profesor.idProfesor')
        ->select('examenteorico.*', DB::raw("CONCAT(profesor.nombre, ' ', profesor.primerApellido, ' ', profesor.segundoApellido) AS nombreCompleto"))
        ->get();
        return view('catalogos/examenteoricoGet', [ #Retorna una vista llamada examenteoricoGet#
            'examenesteoricos' => $examenesteoricos, #Pasa la colección de examenteorico obtenida de la base de datos a la vista.#
            #--ayuda en la navegación del usuario por la interfaz de la aplicación-#
            "breadcrumbs"=>[  
                "Inicio"=>url("/home"),
                "Examen Teórico"=>url("/catalogos/examenteorico")
            ]
        ]);
    }

    // Agregamos un nuevo exámen teórico 
    public function examenteoricoAgregarGet(): View
    {
        $profesores = Profesor::select(
            'idProfesor', 
            DB::raw("CONCAT(nombre, ' ', primerApellido, ' ', segundoApellido) AS nombreCompleto")
        )->where('estado',1)->get();
        return view('catalogos/examenteoricoAgregarGet',[
            "profesores"=>$profesores,
            "breadcrumbs"=>[
                "Inicio"=>url("/home"),
                "Examen Teórico"=>url("/catalogos/examenteorico"),
                "Agregar"=>url("/catalogos/examenteorico/agregar")
            ]
        ]);
    }

    // Guardamos el nuevo exámen teórico
    public function examenteoricoAgregarPost(Request $request){
        $id=$request->input("idProf");
        $titulo=$request->input("titulo");
        $fecha=$request->input("fecha");
        $numPreguntas=$request->input("numPreguntas");
        $estado=1;

        $examenesteorico=new ExamenTeorico([
            "fk_idProfesor"=>$id,
            "titulo"=>strtoupper($titulo),
            "fecha"=>strtoupper($fecha),
            "numPreguntas"=>strtoupper($numPreguntas),
            "estado"=>$estado

        ]);
        $examenesteorico->save();
        return redirect("/catalogos/examenteorico");
    }
    
    // Modificamos un nuevo examen teorico
    public function examenteoricoModificarGet(Request $request, $idExamenTeorico): View
    {
        $examenteorico = ExamenTeorico::find($idExamenTeorico);
        $profesores = Profesor::select(
            'idProfesor', 
            DB::raw("CONCAT(nombre, ' ', primerApellido, ' ', segundoApellido) AS nombreCompleto")
        )->get();

        return view('/catalogos/examenteoricoModificarGet', [
            "examenteorico" => $examenteorico,
            "profesores" => $profesores,  // Asegúrate de pasar también los profesores si los necesitas en la vista
            "breadcrumbs" => [
                "Inicio" => url("/home"),
                "ExamenTeorico" => url("/catalogos/examenteorico"),
                "Modificar" => url("/catalogos/examenteorico/{id}/modificar")
            ]
        ]);
    }

    // Guardamos la modificación
    public function examenteoricoModificarPost(Request $request, $idExamenTeorico){
        $examenteorico=ExamenTeorico::find($idExamenTeorico);
        $examenteorico->fecha = $request->input("fecha");
        $examenteorico->fk_idProfesor=$request->input("fk_idProfesor");
        $examenteorico->titulo=strtoupper($request->input("titulo"));
        $examenteorico->numPreguntas=strtoupper($request->input("numPreguntas"));
        $examenteorico->save();

        return redirect("/catalogos/examenteorico");
    }

/* -------------------------------------------------------------------------------------------------------------------------------- */

}