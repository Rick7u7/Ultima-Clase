<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\DetallesRecintoController;

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

Route::post('/backoffice/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/backoffice/roles', [RolesController::class, 'index'])->name('backoffice.roles.index');
Route::post('/backoffice/roles', [RolesController::class, 'store'])->name('backoffice.roles.new');
Route::post('/backoffice/roles/down/{_id}', [RolesController::class, 'down'])->name('backoffice.roles.down');
Route::post('/backoffice/roles/up/{_id}', [RolesController::class, 'up'])->name('backoffice.roles.up');
Route::post('/backoffice/roles/destroy/{_id}', [RolesController::class, 'destroy'])->name('backoffice.roles.destroy');

Route::get('/backoffice/user/list', [UserController::class, 'listUsers'])->name('backoffice.user.list');

// Géneros
Route::get('/backoffice/genero', [GeneroController::class, 'index'])->name('backoffice.genero.index');
Route::post('/backoffice/genero', [GeneroController::class, 'store'])->name('backoffice.genero.store');
Route::put('/backoffice/genero/{id}', [GeneroController::class, 'update'])->name('backoffice.genero.update');
Route::post('/backoffice/genero/destroy/{id}', [GeneroController::class, 'destroy'])->name('backoffice.genero.destroy');

// Detalles del Recinto
Route::get('/backoffice/detalles-recinto', [DetallesRecintoController::class, 'index'])->name('backoffice.detallesrecinto.index');
Route::post('/backoffice/detalles-recinto', [DetallesRecintoController::class, 'store'])->name('backoffice.detallesrecinto.store');
Route::put('/backoffice/detalles-recinto/{id}', [DetallesRecintoController::class, 'update'])->name('backoffice.detallesrecinto.update');
Route::post('/backoffice/detalles-recinto/destroy/{id}', [DetallesRecintoController::class, 'destroy'])->name('backoffice.detallesrecinto.destroy');