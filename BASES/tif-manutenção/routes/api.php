<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChamadoController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CadastroController;
use App\Http\Controllers\Api\UsuarioController;
use App\Models\Categoria;
use App\Models\Local;
use App\Models\Prioridade;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', DashboardController::class);
    Route::apiResource('chamados', ChamadoController::class);
    Route::get('/catalogos', fn () => response()->json(['locais' => Local::all(), 'categorias' => Categoria::all(), 'prioridades' => Prioridade::all()]));
    Route::get('/cadastros/{tipo}', [CadastroController::class, 'index']);
    Route::post('/cadastros/{tipo}', [CadastroController::class, 'store']);
    Route::put('/cadastros/{tipo}/{id}', [CadastroController::class, 'update']);
    Route::delete('/cadastros/{tipo}/{id}', [CadastroController::class, 'destroy']);
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::put('/usuarios/{user}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy']);
});
