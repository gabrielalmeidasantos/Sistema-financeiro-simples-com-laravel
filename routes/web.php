<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'index'])->name('login.index');
Route::post('/login', [UserController::class, 'login'])->name('login.auth');
Route::get('/logout', [UserController::class, 'logout'])->name('login.logout');
Route::post('/cadastrar', [UserController::class, 'cadastrar'])->name('login.cadastrar');

Route::group(['middleware' => ['fezLogin']], function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [TransacaoController::class, 'dashboardIndex'])->name('dashboard.index');
        Route::get('/dinheiro', [TransacaoController::class, 'dashboardDinheiro'])->name('dashboard.dinheiro');
        Route::get('/atividades', [TransacaoController::class, 'dashboardAtividades'])->name('dashboard.atividades');

        Route::post('/transacao/sacar', [TransacaoController::class, 'dashboardtransacaoSaque'])->name('dashboard.transacao.sacar');
        Route::post('/transacao/depositar', [TransacaoController::class, 'dashboardtransacaoDeposito'])->name('dashboard.transacao.Depositar');

        Route::get('/categorias', [CategoriaController::class, 'dashboardCategorias'])->name('dashboard.categorias');
        Route::post('/categorias', [CategoriaController::class, 'dashboardCategoriasAdicionar'])->name('dashboard.categorias.adicionar');
        Route::delete('/categorias', [CategoriaController::class, 'dashboardCategoriasApagar'])->name('dashboard.categorias.apagar');
    });
});
