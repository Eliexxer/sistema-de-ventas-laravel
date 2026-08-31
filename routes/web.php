<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleVentasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/home', [DashboardController::class, 'index'])->name('home');

Route::prefix('ventas')->group(function () {
    Route::get('/detalle', [DetalleVentasController::class, 'index'])->name('detalles-ventas.index');
    Route::get('/nueva', [VentasController::class, 'index'])->name('nueva-venta.index');
});

Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriasController::class, 'index'])->name('categorias.index');
});

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductosController::class, 'index'])->name('productos.index');
});

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClientesController::class, 'index'])->name('clientes.index');
});

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.index');
});