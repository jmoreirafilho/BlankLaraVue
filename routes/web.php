<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// URL::forceScheme('https');

Route::get('/', function () {
    if (\Auth::check()) {
        return redirect('/home');
    }
    return view('login');
});

Route::get('/{url}', function () {
    if (\Auth::check()) {
        return view('app');
    }
    return redirect('/');
});

use App\Http\Controllers\UsuarioController;
Route::controller(UsuarioController::class)->group(function () {
    Route::post('/login', 'login');
    Route::middleware('auth')->post('/verificar-acesso', 'verificarAcesso');
    Route::middleware('auth')->post('/logout', 'logout');
    Route::middleware('auth')->post('/usuario-logado', 'usuarioLogado');
    
    Route::middleware('auth')->post('/usuarios/buscar', 'buscar');
    Route::middleware('auth')->post('/usuarios', 'salvar');
    Route::middleware('auth')->put('/usuarios', 'atualizar');
    Route::middleware('auth')->delete('/usuarios/{id}', 'remover');
});

use App\Http\Controllers\PerfilController;
Route::controller(PerfilController::class)->group(function () {
    Route::middleware('auth')->post('/perfis/buscar', 'buscar');
    Route::middleware('auth')->post('/perfis', 'salvar');
    Route::middleware('auth')->put('/perfis', 'atualizar');
    Route::middleware('auth')->delete('/perfis/{id}', 'remover');
});

use App\Http\Controllers\ClienteController;
Route::controller(ClienteController::class)->group(function () {
    Route::middleware('auth')->post('/clientes/buscar', 'buscar');
    Route::middleware('auth')->post('/clientes', 'salvar');
    Route::middleware('auth')->put('/clientes', 'atualizar');
    Route::middleware('auth')->delete('/clientes/{id}', 'remover');
});