<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerExame;

/* ROUTE PARA A INDEX */
Route::get('/', function (){return view('index');}); 

/* ROUTE PARA AS TELAS DE INDICADORES DE EXAMES */
Route::get('/exames', function(){ return view('cadastro-exames');});

Route::get('/visualizar-exames', [ControllerExame::class, 'getExames']); 

Route::post('/exames/cadastrar', [ControllerExame::class, 'cadastrarExames'])->name('exames.cadastrar');
/****************************************************************************************************** */
?>