<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
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
Route::get('/admin/pedidos', [AdminController::class, 'pedidos'])->middleware("auth")->name('pedidos.index');
Route::get('/admin/pedidosCompletados', [AdminController::class, 'pedidosCompletados'])->middleware("auth")->name('pedidosCompletados.index');
Route::post('/admin/pedidos/{id}/completar', [AdminController::class, 'marcarPedidoCompletado'])->middleware("auth")->name('pedidos.completar');


Route::post('/admin/productos', [AdminController::class, 'storeProducto'])->middleware("auth")->name('productos.store');
Route::delete('/admin/productos', [AdminController::class, 'deleteProductos'])->middleware("auth")->name('productos.delete');
Route::delete('/admin/producto/{id}', [AdminController::class, 'deleteProducto'])->middleware("auth")->name('productos.deleteUno');


Route::post('/admin/cambiar-tienda', [AdminController::class, 'cambiarTienda'])->middleware("auth")->name('cambiarTienda');
Route::post('/admin/cambiarMensaje', [AdminController::class, 'cambiarMensaje'])->middleware("auth")->name('cambiarMensaje');


Route::middleware(['auth','cliente'])->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::get('/order', [OrderController::class, 'index'])->name('order.index');