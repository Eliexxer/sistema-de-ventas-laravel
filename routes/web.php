<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleVentasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;

Route::get("/crear-admin", [AuthController::class, 'crearAdmin']);

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'login'])->name('logear');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('ventas')->middleware('auth')->group(function () {
    Route::get('/detalle', [DetalleVentasController::class, 'index'])->name('detalles-ventas.index');
    Route::get('/nueva', [VentasController::class, 'index'])->name('nueva-venta.index');
});

Route::prefix('categorias')->middleware('auth')->group(function () {
    Route::get('/', [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/create', [CategoriasController::class, 'create'])->name('categorias.create');
    Route::post('/store', [CategoriasController::class, 'store'])->name('categorias.store');
    Route::get('/show/{id}', [CategoriasController::class, 'show'])->name('categorias.show');
    Route::get('/edit/{id}', [CategoriasController::class, 'edit'])->name('categorias.edit');
    Route::put('/update/{id}', [CategoriasController::class, 'update'])->name('categorias.update');
    Route::delete('/destroy/{id}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');
});

Route::prefix('productos')->middleware('auth')->group(function () {
    Route::get('/', [ProductosController::class, 'index'])->name('productos.index');
});

Route::prefix('proveedores')->middleware('auth')->group(function () {
    Route::get('/', [ProveedoresController::class, 'index'])->name('proveedores.index');
    Route::get('/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
    Route::post('/store', [ProveedoresController::class, 'store'])->name('proveedores.store');
    Route::get('/show/{id}', [ProveedoresController::class, 'show'])->name('proveedores.show');
    Route::get('/edit/{id}', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
    Route::put('/update/{id}', [ProveedoresController::class, 'update'])->name('proveedores.update');
    Route::delete('/destroy/{id}', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');
});

Route::prefix('usuarios')->middleware('auth')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/store', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/show/{id}', [UsuariosController::class, 'show'])->name('usuarios.show');
    Route::get('/edit/{id}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::put('/update/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/destroy/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/tbody', [UsuariosController::class, 'tbody'])->name('usuarios.tbody');
    Route::get('cambiar-estado/{id}/{estado}', [UsuariosController::class, 'estado'])->name('usuarios.estado');
    Route::post('/cambio-password', [UsuariosController::class, 'cambiarPassword'])->name('usuarios.cambioPassword');
});