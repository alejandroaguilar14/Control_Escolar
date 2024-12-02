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



});