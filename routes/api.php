<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AsignaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CajaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [UserController::class, 'login']);
Route::post('/recuperar', [UserController::class, 'recuperar']);

Route::group(['middleware' => ['auth:sanctum', 'role:administrador']], function () {
    // Rutas solo accesibles para el role 'administrador'
    Route::post('/productos', [ProductoController::class, 'store'])->name('api.productos.store');
    Route::post('/editproducto/{id}', [ProductoController::class, 'update'])->name('api.productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('api.productos.destroy');
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('api.productos.show');

    Route::post('/register', [UserController::class, 'register'])->name('api.register');
    Route::get('/allusers', [UserController::class, 'allUsers'])->name('api.allusers');
    Route::delete('/deleteuser/{id}', [UserController::class, 'deleteUser'])->name('api.deleteuser');
    Route::get('user/{id}', [UserController::class, 'getUser'])->name('api.getuser');
    Route::post('user/{id}', [UserController::class, 'updateUser'])->name('api.updateuser');

    Route::get('/events', [EventController::class, 'AllEvents'])->name('api.events');

    Route::get('/PedidosDia', [VentaController::class, 'totalPedidosDia'])->name('api.pedidosdia');
    Route::get('/PedidosSemana', [VentaController::class, 'totalPedidosSemana'])->name('api.pedidossemana');
    Route::get('/PedidosMes', [VentaController::class, 'totalPedidosMes'])->name('api.pedidosmes');

});

Route::group(['middleware' => ['auth:sanctum', 'role:cajero']], function () {
    // Rutas solo accesibles para el role 'cajero'
    Route::post('/venta', [VentaController::class, 'venta'])->name('api.venta');
    Route::post('/asigna', [AsignaController::class, 'asigna'])->name('api.asigna');

    Route::post('/openCaja', [CajaController::class, 'openCaja'])->name('api.caja');
    Route::post('/closeCaja', [CajaController::class, 'closeCaja'])->name('api.closecaja');
    Route::get('/validateCaja', [CajaController::class, 'validateCaja'])->name('api.validatecaja');
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('/productos', [ProductoController::class, 'allproducts'])->name('api.productos');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
