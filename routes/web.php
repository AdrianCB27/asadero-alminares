<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TiendaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'logged'])->name('logged');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'registroVista'])->name('registroVista');
Route::post('/registro', [AuthController::class, 'registrarse'])->name('registrarse');

Route::middleware(['auth', 'cliente'])->group(function () {
    Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda');
});Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::get('/admin/clientes', [AdminController::class, 'clientes'])->middleware("auth")->name('clientes.index');
Route::get('/admin/clientes/{id}/eliminar', [AdminController::class, 'eliminarCliente'])->middleware("auth")->name('clientes.eliminar');
Route::get('/admin/productos', [AdminController::class, 'productos'])->middleware("auth")->name('productos.index');
Route::post('/admin/productos', [AdminController::class, 'storeProducto'])->middleware("auth")->name('productos.store');
Route::delete('/admin/productos', [AdminController::class, 'deleteProductos'])->middleware("auth")->name('productos.delete');

Route::post('/admin/cambiar-tienda', [AdminController::class, 'cambiarTienda'])->middleware("auth")->name('cambiarTienda');

Route::middleware(['auth','cliente'])->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});