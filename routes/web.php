<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerExame;
use App\Http\Controllers\ControllerComercial;
use App\Http\Controllers\ControllerUsuario;
use App\Http\Controllers\ControllerSeguranca;
use App\Http\Controllers\ControllerAmbiental;

/* ROUTE PARA A INDEX */
Route::get('/', function (){return view('index');});

Route::get('/graphs', function (){return view('visualizar-indicadores');});

/* ***************************************************************************************************** */

/* ROUTE PARA AS TELAS DE CADASTRO DE USUARIO */

Route::get('/usuario', function(){return view('cadastro-usuario'); });

Route::post('/usuario/cadastrar', [ControllerUsuario::class, 'cadastrarUsuario'])->name('user.cadastrar');

Route::post('/login', [ControllerUsuario::class, 'logarUsuario'])->name('user.login');

Route::get('/login', function(){return view('login');});

Route::get('/logout', function(){ Session::flush(); return redirect('/login');});

Route::get('/visualizar-usuarios', [ControllerUsuario::class, 'getUsuarios']);

Route::get('/visualizar-usuarios/deletar/{id}', [ControllerUsuario::class, 'deleteUsuario'])->name('usuario.excluir');
/* ***************************************************************************************************** */

/* ROUTE PARA AS TELAS DE INDICADORES DE EXAMES */

Route::get('/exames', function(){ return view('cadastro-exames');}); # para a tela de cadastro de indicadores de exames

Route::get('/visualizar-exames', [ControllerExame::class, 'getExames']); # para a tela de visualização de indicadores de exames

Route::post('/exames/cadastrar', [ControllerExame::class, 'cadastrarExames'])->name('exames.cadastrar'); # post que faz o cadastro dos indicadores de exames no banco

Route::get('/visualizar-exames/deletar/{id}', [ControllerExame::class, 'deletarIndicador'])->name('exame.deletar');

/* ***************************************************************************************************** */

/* ROUTE PARA AS TELAS DE INDICADORES DO COMERCIAL */

Route::get('/comercial', function(){ return view('cadastro-comercial'); });

Route::get('/visualizar-comercial', [ControllerComercial::class, 'getComercial']);

Route::post('/comercial/cadastrar', [ControllerComercial::class, 'cadastrarIndicador'])->name('comercial.cadastrar');

Route::get('/visualizar-comercial/deletar/{id}', [ControllerComercial::class, 'deletarIndicador'])->name('comercial.deletar');

/* ***************************************************************************************************** */

/* ROUTE PARA AS TELAS DE INDICADORES DA SEGURANÇA */

Route::get('/seguranca', function(){ return view('cadastro-seguranca');});

Route::get('/visualizar-seguranca', [ControllerSeguranca::class, 'getSeguranca']);

Route::post('/seguranca/cadastrar', [ControllerSeguranca::class, 'cadastrarIndicador'])->name('seguranca.cadastrar');

Route::get('/visualizar-seguranca/deletar/{id}', [ControllerSeguranca::class, 'deletarIndicador'])->name('seguranca.deletar');

/* ***************************************************************************************************** */

/* ROUTE PARA AS TELAS DE INDICADORES DO AMBIENTAL */

Route::get('/ambiental', function(){ return view('cadastro-ambiental');});

Route::get('/visualizar-ambiental', [ControllerAmbiental::class, 'getAmbiental']);

Route::post('/ambiental/cadastrar', [ControllerAmbiental::class, 'cadastrarIndicador'])->name('ambiental.cadastrar');

Route::get('/visualizar-ambiental/deletar/{id}', [ControllerAmbiental::class, 'deletarIndicador'])->name('ambiental.deletar');
?>
