<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CreadorController;
use App\Http\Controllers\EjecutorController;
use App\Http\Controllers\VisadorController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/',[LoginController::class,'login'])->name('get.ini');

Route::get('/creador',[CreadorController::class,'index'])->name('get.creador');
Route::get('/creador/lista',[CreadorController::class,'listaRequerimientos'])->name('get.lstReq');

Route::get('/visador',[VisadorController::class,'index'])->name('get.visador');
Route::get('/visador/detalle/{id}',[VisadorController::class,'visaDetalle'])->name('get.detalleReq');

Route::get('/ejecutor',[EjecutorController::class,'index'])->name('get.ejecutor');




Route::post('/login', [LoginController::class,'postLgn'])->name('post.Login');  
Route::post('/descripciones', [ApiController::class,'descripciones'])->name('post.desc');
Route::post('/institucion', [ApiController::class,'instituciones'])->name('post.inst');
Route::post('/addrequerimiento', [ApiController::class,'addRequerimiento'])->name('post.addreq');
Route::post('/lstReqCreador', [ApiController::class,'lstRequerimientosCreador'])->name('post.lstReq');
Route::post('/detallerequerimiento', [ApiController::class,'retDetalleReq'])->name('post.detReq');
Route::post('/actequerimiento', [ApiController::class,'actualizaReq'])->name('post.actReq');
Route::post('/imagen', [ApiController::class,'retImagen'])->name('post.imagen');




