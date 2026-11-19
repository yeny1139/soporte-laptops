<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\TecnicoController;
use Illuminate\Support\Facades\Route;

// Redirección inicial al login
Route::get('/', fn () => redirect()->route('login'));

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas del sistema
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::resource('clientes', ClienteController::class);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('ordenes', OrdenServicioController::class);
    Route::resource('reparaciones', ReparacionController::class);
});