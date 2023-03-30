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

Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function(){
    Route::get('/', [PostController::class, 'index']);
    Route::post('add', [PostController::class, 'add']);
});


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
?>