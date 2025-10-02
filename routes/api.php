<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AutController;

Route::post('/user', [UserController::class, 'store']);
//el middleware es para ver el prerequisito que quiere decir
//que verifica si la peticion trae la Api
Route::middleware('auth:sanctum')->group(function () {
    //RUTAS PARA EL USER
    Route::get('/user', [UserController::class, 'index']);
    //trae un solo item
    Route::get('/user/{id}', [UserController::class, 'show']);
    //Actualiza el ususario
    Route::patch('/users/{id}', [UserController::class, 'update']);
    //RUTAS PARA SUS NOTAS
    route::post('/note', [NoteController::class, 'store']);
    route::get('/note', [NoteController::class, 'index']);
    route::patch('notes/{id}', [NoteController::class, 'update']);
    route::get('/note/{fecha}/{id}', [NoteController::class, 'show']);
    route::delete('/note/{id}', [NoteController::class, 'destroy']);
    //LOGOUT
    Route::post('/logout', [AutController::class, 'logout']);
});
//Rutas para la auntenticacion
route::post('/Auth', [AutController::class, 'Login']);
