<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PdfController;
use App\Http\Middleware\auth_api;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/enviar_codigo', [UsuarioController::class, 'enviar_codigo']);

Route::post('/enviar_reset_senha', [UsuarioController::class, 'enviar_reset_senha']);

Route::post('/validar_codigo_reset', [UsuarioController::class, 'validar_codigo_reset']);

Route::post('/confirmar_nova_senha', [UsuarioController::class, 'confirmar_nova_senha']);

Route::get('/exportar-pdf', [PdfController::class, 'exportar_pdf']);

Route::get( '/todos_doces',[TestController::class,'todos_doces']);

Route::post('/Cadastro_usuario', [UsuarioController::class,'cadastra_usuario']);

Route::post('/Login', [UsuarioController::class, 'login']);

Route::get('/testa-email/{id_usuario}', [UsuarioController::class, 'testa_email']);
//Coisas que precisam de token

Route::middleware(auth_api::class)->group(function () {

Route::post( '/salva_doce',[TestController::class,'salva_doce']);

Route::get( '/exibe_doce/{id}',[TestController::class,'exibe_doce']);

Route::post('/comprar/{id}', [TestController::class, 'comprar_doce']);


Route::get('/carrinho', [TestController::class, 'listar_carrinho']);

Route::post('/compras/{id}/avancar', [TestController::class, 'avancar_compra']);

Route::delete('/deleta_doce/{id}', [TestController::class, 'deleta_doce']);


Route::match(['post', 'put'], '/atualiza_doce/{id}', [TestController::class, 'atualiza_doce']);

Route::get('/perfil',[UsuarioController::class, 'exibe_perfil']);

Route::put('/perfil',[UsuarioController::class, 'atualiza_perfil']);

Route::put('/perfil/dupla-autentica',[UsuarioController::class, 'atualiza_dupla_autentica']);

Route::put('/perfil/senha',[UsuarioController::class, 'atualiza_senha']);

Route::post('/logout',[UsuarioController::class, 'logout']);
});
