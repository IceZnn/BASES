<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::middleware('auth')->group(function () {
    Route::get('/home', fn () => view('home'))->name('home');
    Route::get('/abrir-chamado', fn () => view('chamados.form'))->name('chamados.open');
    Route::get('/chamados/create', fn () => view('chamados.form'))->name('chamados.create');
    Route::get('/meus-chamados', fn () => view('chamados.index', ['meus' => true]))->name('chamados.mine');
    Route::get('/perfil', fn () => view('profile'))->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware(['auth', 'perfil:Administrador,Manutenção'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/chamados', fn () => view('chamados.index', ['meus' => false]))->name('chamados.index');
    Route::get('/demonstracao-automacao', fn () => view('automation'))->name('automation');
    Route::get('/relatorios', fn () => view('dashboard'))->name('relatorios');
    Route::get('/categorias', fn () => view('cadastros', ['tipo' => 'categorias']))->name('categorias');
    Route::get('/locais', fn () => view('cadastros', ['tipo' => 'locais']))->name('locais');
});
