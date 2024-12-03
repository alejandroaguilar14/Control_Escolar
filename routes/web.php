<?php
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get ('/', function () {

    return view('home',["breadcrumbs"=>[]]);
});

Route::view("login","login")->name("login");

//Login
Route::get('/',[CatalogosController::class, "home"]);
Route::post('/login',[CatalogosController::class, "login"]);

Route::get('/registrar',[CatalogosController::class, "registrar"]);
Route::post('/register',[CatalogosController::class, "register"]);

//Salir
Route::get('/logout',[CatalogosController::class, "logout"]);

Route::middleware('auth')->group(function () {
//Rutas protegidas
Route::get('/home', [CatalogosController::class, "inicio"]);

// Grupos
Route::get("/catalogos/grupos", [CatalogosController::class, "gruposGet"]);
Route::get("/catalogos/grupos/deshabilitados", [CatalogosController::class, "gruposDeshabilitadosGet"]);
Route::get("/catalogos/grupos/{idGrupo}/deshabilitar", [CatalogosController::class, "deshabilitarGrupo"]);
Route::get("/catalogos/grupos/{idGrupo}/habilitar", [CatalogosController::class, "habilitarGrupo"]);
Route::get('/catalogos/grupos/agregar', [CatalogosController::class, 'mostrarFormularioAgregar']);
Route::post('/catalogos/grupos/agregar', [CatalogosController::class, 'agregarGrupo']);
Route::get('/catalogos/grupos/{id}/modificar', [CatalogosController::class, 'mostrarFormularioModificar']);
Route::put('/catalogos/grupos/{id}/modificar', [CatalogosController::class, 'modificarGrupo']);


// Mostrar vistas de tablas
    
Route::get ("/catalogos/alumnos",[CatalogosController::class, "alumnosGet"])->name('alumnos.get');

Route::get ("/catalogos/profesores",[CatalogosController::class, "profesoresGet"]);

Route::get ("/catalogos/examenteorico",[CatalogosController::class, "examenteoricoGet"]);

Route::get ("/catalogos/examenpractico",[CatalogosController::class, "examenpracticoGet"]);

// Mostrar vistas para eliminar un algun registro

Route::get ("/catalogos/alumnos/{id}/eliminar",[CatalogosController::class, "alumnosDelete"])->where("id","[0-9]+");
Route::get("/catalogos/alumnos/eliminados", [CatalogosController::class, 'alumnosEliminados']);
Route::get ("/catalogos/alumnos/{id}/activar",[CatalogosController::class, "alumnoActivar"])->where("id","[0-9]+");

Route::get ("/catalogos/profesores/{id}/eliminar",[CatalogosController::class, "profesoresDelete"])->where("id","[0-9]+");
Route::get("/catalogos/profesores/eliminados", [CatalogosController::class, 'profesoresEliminados']);
Route::get ("/catalogos/profesores/{id}/activar",[CatalogosController::class, "profesorActivar"])->where("id","[0-9]+");

// Mostrar vistas de tablas para agregar registros

Route::get ("/catalogos/profesores/agregar",[CatalogosController::class, "profesoresAgregarGet"]);
Route::post ("/catalogos/profesores/agregar",[CatalogosController::class, "profesoresAgregarPost"]);


Route::get ("/catalogos/alumnos/agregar",[CatalogosController::class, "alumnosAgregarGet"]);
Route::post ("/catalogos/alumnos/agregar",[CatalogosController::class, "alumnosAgregarPost"]);


Route::get ("/catalogos/examenpractico/agregar",[CatalogosController::class, "examenpracticoAgregarGet"]);
Route::post ("/catalogos/examenpractico/agregar",[CatalogosController::class, "examenpracticoAgregarPost"]);


Route::get ("/catalogos/examenteorico/agregar",[CatalogosController::class, "examenteoricoAgregarGet"]);
Route::post ("/catalogos/examenteorico/agregar",[CatalogosController::class, "examenteoricoAgregarPost"]);


// Mostrar vistas para modificar los registros

// Modificar Evaluaciones
Route::get("/movimientos/evaluaciones/{id}/modificar",[MovimientosController::class, "evaluacionesModificarGet"])->where("id","[0-9]+");
Route::post("/movimientos/evaluaciones/{id}/modificar",[MovimientosController::class, "evaluacionesModificarPost"])->where("id","[0-9]+");

// Modificar Alumnos
Route::get("/catalogos/alumnos/{id}/modificar",[CatalogosController::class, "alumnosModificarGet"])->where("id","[0-9]+");
Route::post("/catalogos/alumnos/{id}/modificar",[CatalogosController::class, "alumnosModificarPost"])->where("id","[0-9]+");

// Modificar Profesores
Route::get("/catalogos/profesores/{id}/modificar",[CatalogosController::class, "profesoresModificarGet"])->where("id","[0-9]+");
Route::post("/catalogos/profesores/{id}/modificar",[CatalogosController::class, "profesoresModificarPost"])->where("id","[0-9]+");

Route::get("/movimientos/alumnos/{id}/evaluaciones",[MovimientosController::class, "alumnosEvaluacionesGet"])->where("id","[0-9]+");

// Modificar Examen Práctico
Route::get("/catalogos/examenpractico/{id}/modificar",[CatalogosController::class, "examenpracticoModificarGet"])->where("id","[0-9]+");
Route::post("/catalogos/examenpractico/{id}/modificar",[CatalogosController::class, "examenpracticoModificarPost"])->where("id","[0-9]+");

//Modificar Examen Teórico
Route::get("/catalogos/examenteorico/{id}/modificar",[CatalogosController::class, "examenteoricoModificarGet"])->where("id","[0-9]+");
Route::post("/catalogos/examenteorico/{id}/modificar",[CatalogosController::class, "examenteoricoModificarPost"])->where("id","[0-9]+");

//Agregar evaluaciones
Route::get("/movimientos/evaluaciones", [MovimientosController::class, "evaluacionesGet"]);
Route::get('/movimientos/evaluaciones/agregar', [MovimientosController::class, 'agregarEvaluacion']);
Route::post('/movimientos/evaluaciones/agregar', [MovimientosController::class, 'guardarEvaluacion']);
Route::get("/movimientos/evaluaciones/deshabilitadas", [MovimientosController::class, "evaluacionesDeshabilitadasGet"]);
Route::get("/movimientos/evaluaciones/{idEvaluacion}/deshabilitar", [MovimientosController::class, "deshabilitarEvaluacion"]);
Route::get("/movimientos/evaluaciones/{idEvaluacion}/habilitar", [MovimientosController::class, "habilitarEvaluacion"]);
Route::get('/movimientos/evaluaciones/{id}/calificaciones', [MovimientosController::class, 'mostrarCalificaciones']);
Route::post('/movimientos/evaluaciones/{id}/calificaciones', [MovimientosController::class, 'guardarCalificaciones']);
Route::get('/movimientos/evaluaciones/{id}/modificar', [MovimientosController::class, 'editarEvaluacion']);
Route::post('/movimientos/evaluaciones/{id}/modificar', [MovimientosController::class, 'actualizarEvaluacion']);
Route::get('/obtener-alumnos/{grupo}', [MovimientosController::class, 'obtenerAlumnos']);

//Modificaciones
Route::get("/catalogos/examenpractico/{id}/profesores",[CatalogosController::class, "profesoresExamenesPracticosGet"])->where("id","[0-9]+");
Route::get("/catalogos/examenpractico/{id}/profesores/agregar",[CatalogosController::class, "profesoresExamenesPracticosAgregarGet"])->where("id","[0-9]+");
Route::post("/catalogos/examenpractico/{id}/profesores/agregar",[CatalogosController::class, "profesoresExamenesPracticosAgregarPost"])->where("id","[0-9]+");
Route::get("/catalogos/examenpractico/{id}/profesores/modificar",[CatalogosController::class, "profesoresExamenesPracticosModificarGet"])->where("id","[0-9]+");
Route::post("/catalogos/examenpractico/{id}/profesores/modificar",[CatalogosController::class, "profesoresExamenesPracticosModificarPost"])->where("id","[0-9]+");

// Reportes 
Route::get("/reportes",[ReportesController::class,"indexGet"]);
Route::get("/reportes/notas",[ReportesController::class,"notasGet"]);
Route::get("/reportes/examenes",[ReportesController::class,"examenesGet"]);

// PDFs
Route::get("/reportes/notaspdfGet",[ReportesController::class,"notaspdfGet"])->name("viewNotaspdf");
Route::get("/reportes/notasdownloadpdfGet",[ReportesController::class,"notasdownloadpdfGet"])->name("downloadNotaspdf");

Route::get("/reportes/examenespdfGet",[ReportesController::class,"examenespdfGet"])->name("viewExamenespdf");
Route::get("/reportes/examenesdownloadpdfGet",[ReportesController::class,"examenesdownloadpdfGet"])->name("downloadExamenespdf");

Route::post('/guardar-grafica', 'ReportesController@guardarImagen');

});