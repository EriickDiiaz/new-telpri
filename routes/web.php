<?php
use App\Http\Controllers\LineaController;
use App\Http\Controllers\CallcenterController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PisoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();
Auth::routes(['register'=>false, 'reset'=>false]);

Route::middleware('auth')->group(function () {
    Route::get('/get-pisos/{localidad_id}', [LineaController::class, 'getPisosByLocalidad'])->name('getPisosByLocalidad');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('lineas/pdf-axe', [LineaController::class, 'generatePDFAxe']);
    Route::get('lineas/axe', [LineaController::class, 'axe'])->name('lineas/axe');
    Route::get('lineas/pdf-cisco', [LineaController::class, 'generatePDFCisco']);
    Route::get('lineas/cisco', [LineaController::class, 'cisco'])->name('lineas/cisco');
    Route::get('lineas/pdf-ericsson', [LineaController::class, 'generatePDFEricsson']);
    Route::get('lineas/ericsson', [LineaController::class, 'ericsson'])->name('lineas/ericsson');
    Route::get('lineas/pdf-externo', [LineaController::class, 'generatePDFExterno']);
    Route::get('lineas/externo', [LineaController::class, 'externo'])->name('lineas/externo');    
    Route::get('lineas/avanzada', [LineaController::class, 'avanzada'])->name('lineas/avanzada');
    Route::get('lineas/historial', [LineaController::class, 'historial'])->name('lineas/historial');
 
    Route::resource('/lineas', LineaController::class);

    Route::get('/callcenters/pdf-callcenter', [CallcenterController::class, 'generatePDF']);
    Route::resource('/callcenters', CallcenterController::class);
    
    Route::resource('/localidades', LocalidadController::class);
    Route::resource('/pisos', pisoController::class);
    Route::resource('/usuarios', UsuarioController::class);
    Route::resource('/campos', CampoController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permisos', PermisoController::class);
});