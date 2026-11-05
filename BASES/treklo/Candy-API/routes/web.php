<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Middleware\auth_api;
use FontLib\Table\Type\name;

Route::get('/', function () {
    return view('login');
})->name('Login');

Route::get('/doces', function () {
    return view('doces');
})->name('doces');

Route::get('/Inicio', function () {
    return view('inicial');
})->name('Inicio');

Route::get('/Dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/Cadastro', function () {
    return view('cadasDoce');
})->name('cadastro');

Route::get('/Sobre', function () {
    return view('Sobre');
})->name('sobre');

Route::get('/Cadastro_usuario', function () {
    return view('cadastro');
});

Route::get('/Login', function () {
    return view('login');
})->name('login');

Route::get('/Perfil', function () {
    return view('perfil');
});

Route::get('/digita_codigo', function () {
    return view('digita_codigo');
})->name('digita_codigo');

Route::get('/esqueci_senha', [\App\Http\Controllers\UsuarioController::class, 'esqueci_senha'])->name('esqueci_senha');

Route::get('/digita_reset_senha', function () {
    return view('digita_reset_senha');
})->name('digita_reset_senha');

Route::get('/alterar_senha', function () {
    return view('alterar_senha');
})->name('alterar_senha');




/* TOKEN */

Route::middleware(auth_api::class)->group(function () {

    Route::get('/doce/{id}', [TestController::class, 'exibe_doce_view'])->name('doces.detalhe');

    Route::get('/editar/{id}', [TestController::class, 'editar_doce'])->name('doces.editar');

    Route::get('/deletar/{id}', [TestController::class, 'mostrar_formulario_delete'])->name('mostrar_delete');

    Route::delete('/deletar/{id}', [TestController::class, 'deleta_doce'])->name('deleta_doces');

});

Route::get('/carrinho', function () {
    $token = request()->cookie('token');
    $userId = request()->cookie('user_id');

    // deixa livre: carrinho pode abrir, e o front decide se consegue carregar as compras



    return view('carrinho');
})->name('carrinho');


require __DIR__.'/auth.php';
