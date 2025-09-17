<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\DetallesRecintoController;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\SaldoController;

Route::get('/', function () {
    return view('landing/index');
})->name('/');

Route::get('/backoffice', [DashboardController::class, 'index'])->name('backoffice.dashboard');

//usuario
Route::get('/backoffice/login', [UserController::class, 'showFormLogin'])->name('user.form.show.login');
Route::post('/backoffice/login', [UserController::class, 'login'])->name('user.form.login');

Route::get('/backoffice/create-user', [UserController::class, 'showFormRegistro'])->name('user.form.show.registro');
Route::post('/backoffice/create-user', [UserController::class, 'guardarNuevo'])->name('user.form.registro');

Route::get('/backoffice/user/profile', [UserController::class, 'showPerfil'])->name('backoffice.user.profile');
Route::get('/backoffice/user/contact', [UserController::class, 'showContacto'])->name('backoffice.user.contact');
Route::get('/backoffice/user/security', [UserController::class, 'showSeguridad'])->name('backoffice.user.security');
Route::post('/backoffice/user/security', [UserController::class, 'cambiarClave'])->name('backoffice.user.security.changePass');
Route::get('/backoffice/user/saldo', [UserController::class, 'showSaldo'])->name('backoffice.user.saldo');

Route::post('/backoffice/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/backoffice/roles', [RolesController::class, 'index'])->name('backoffice.roles.index');
Route::post('/backoffice/roles', [RolesController::class, 'store'])->name('backoffice.roles.new');
Route::post('/backoffice/roles/down/{_id}', [RolesController::class, 'down'])->name('backoffice.roles.down');
Route::post('/backoffice/roles/up/{_id}', [RolesController::class, 'up'])->name('backoffice.roles.up');
Route::post('/backoffice/roles/destroy/{_id}', [RolesController::class, 'destroy'])->name('backoffice.roles.destroy');

Route::get('/backoffice/cargos', [CargosController::class, 'index'])->name('backoffice.cargos.index');
Route::post('/backoffice/cargos', [CargosController::class, 'store'])->name('backoffice.cargos.new');
Route::post('/backoffice/cargos/down/{_id}', [CargosController::class, 'down'])->name('backoffice.cargos.down');
Route::post('/backoffice/cargos/up/{_id}', [CargosController::class, 'up'])->name('backoffice.cargos.up');
Route::post('/backoffice/cargos/destroy/{_id}', [CargosController::class, 'destroy'])->name('backoffice.cargos.destroy');

Route::get('/backoffice/user/list', [UserController::class, 'listUsers'])->name('backoffice.user.list');

// Géneros
Route::get('/backoffice/genero', [GeneroController::class, 'index'])->name('backoffice.genero.index');
Route::post('/backoffice/genero', [GeneroController::class, 'store'])->name('backoffice.genero.store');
Route::post('/backoffice/genero/down/{_id}', [GeneroController::class, 'down'])->name('backoffice.genero.down');
Route::post('/backoffice/genero/up/{_id}', [GeneroController::class, 'up'])->name('backoffice.genero.up');
Route::post('/backoffice/genero/destroy/{id}', [GeneroController::class, 'destroy'])->name('backoffice.genero.destroy');

// Detalles del Recinto
Route::get('/backoffice/detalles-recinto', [DetallesRecintoController::class, 'index'])->name('backoffice.detallesrecinto.index');
Route::post('/backoffice/detalles-recinto', [DetallesRecintoController::class, 'store'])->name('backoffice.detallesrecinto.store');
Route::post('/backoffice/detalles-recinto/down/{_id}', [DetallesRecintoController::class, 'down'])->name('backoffice.detallesrecinto.down');
Route::post('/backoffice/detalles-recinto/up/{_id}', [DetallesRecintoController::class, 'up'])->name('backoffice.detallesrecinto.up');
Route::post('/backoffice/detalles-recinto/destroy/{id}', [DetallesRecintoController::class, 'destroy'])->name('backoffice.detallesrecinto.destroy');

// Entrenador
Route::get('/backoffice/entrenador', [EntrenadorController::class, 'index'])->name('backoffice.entrenador.index');
Route::post('/backoffice/entrenador', [EntrenadorController::class, 'store'])->name('backoffice.entrenador.store');
Route::post('/backoffice/entrenador/down/{_id}', [EntrenadorController::class, 'down'])->name('backoffice.entrenador.down');
Route::post('/backoffice/entrenador/up/{_id}', [EntrenadorController::class, 'up'])->name('backoffice.entrenador.up');

// Jugadores: Paula, Indira, Javiera

Route::get('/backoffice/jugadores', [JugadoresController::class, 'index'])->name('backoffice.jugadores.index');
Route::post('/backoffice/jugadores', [JugadoresController::class, 'store'])->name('backoffice.jugadores.new');
Route::post('/backoffice/jugadores/down/{_id}', [JugadoresController::class, 'down'])->name('backoffice.jugadores.down');
Route::post('/backoffice/jugadores/up/{_id}', [JugadoresController::class, 'up'])->name('backoffice.jugadores.up');
Route::post('/backoffice/jugadores/destroy/{_id}', [JugadoresController::class, 'destroy'])->name('backoffice.jugadores.destroy');

// Saldos
Route::get('/backoffice/saldo', [SaldoController::class, 'index'])->name('backoffice.saldos.index');
Route::post('/backoffice/saldo', [SaldoController::class, 'store'])->name('backoffice.saldos.new');
Route::put('/backoffice/saldo/{id}', [SaldoController::class, 'update'])->name('backoffice.saldos.update');