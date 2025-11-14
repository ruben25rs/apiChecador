<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlantelController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Ejemplo: solo admins
    Route::get('/admin/data', function () {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Acceso denegado'], 403);
        }
        return response()->json(['message' => 'Bienvenido Admin']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Gggg

Route::post('/actualizar/docente', [DocenteController::class, 'updateDocente']);   
Route::post('/registro/docente', [DocenteController::class, 'store']);
Route::get('/docente/{id}', [DocenteController::class, 'docenteUser']);
Route::get('/docentes/{plantel_id}', [DocenteController::class, 'index']);

Route::post('/registro/asistencias', [AsistenciaController::class, 'store']);
Route::get('/planteles', [PlantelController::class, 'getPlanteles']);

