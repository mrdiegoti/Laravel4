<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;

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

// Ruta protegida por el middleware 'auth:sanctum'
// Devuelve el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // Retorna el usuario actualmente autenticado
});

// Agrupación de rutas para el UserController
Route::controller(UserController::class)->group(function() {
    Route::post('register', 'register'); // Ruta para registrar un nuevo usuario
    Route::get('user/{user}', 'show'); // Ruta para mostrar un usuario específico
    Route::get('user/{user}/address', 'show_address'); // Ruta para mostrar la dirección de un usuario específico
    Route::post('users/{user}/events/{event}/book', 'bookEvent'); // Ruta para reservar un evento para un usuario específico
    Route::get('user/{user}/events', 'listEvents'); // Ruta para listar todos los eventos de un usuario específico
});

// Agrupación de rutas para el EventController
Route::controller(EventController::class)->group(function() {
    Route::post('event', 'store'); // Ruta para crear un nuevo evento
    Route::get('event/{event}/users', 'listUsers'); // Ruta para listar todos los usuarios asociados a un evento específico
});

//EventsTypeController routing
Route::controller(EventTypeController::class)->group(function() {
    Route::post('store', 'store');
    Route::get('type/{type}', 'listEvents');

});

