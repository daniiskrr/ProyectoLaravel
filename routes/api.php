<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('logout',[UserController::class,'logout'])->middleware(middleware:'auth:sanctum');
Route::get('tienda', [PostController::class,'tienda']);
Route::get('tiendaall', [PostController::class,'tiendaall']);
Route::get('suscripciones', [PostController::class,'suscripciones']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'posts'], function(){
        Route::get('/', [PostController::class, 'index']);
        Route::post('add', [PostController::class, 'add']);
        Route::get('edit/{id}', [PostController::class,'edit']);
        Route::post('update/{id}', [PostController::class,'update']);
        Route::delete('{id}', [PostController::class, 'eliminaProducto']);
        Route::get('ofertas', [PostController::class,'ofertas']);
        Route::post('finalizarPedido', [PostController::class,'finalizarPedido']);
        Route::post('actualizarSuscripciones', [PostController::class,'actualizarSuscripciones']);
        Route::get('{id}', [PostController::class, 'obtenerPedidos']);

    });

    Route::group(['prefix' => 'users'], function(){
        Route::get('/', [UserController::class, 'index']);
        Route::post('add', [UserController::class, 'add']);
        Route::get('edit/{id}', [UserController::class,'edit']);
        Route::post('update/{id}', [UserController::class,'update']);
        Route::delete('{id}', [UserController::class, 'eliminaUsuario']);
        Route::get('{id}', [UserController::class, 'mostrarDatos']);
        Route::post('{id}', [UserController::class, 'datosActualizados']);
    });
});



/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
?>
