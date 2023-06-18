<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Models\Producto;
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

//Rutas productos

Route::get('/productos', [ProductoController::class, 'allproducts'])->name('api.productos');
Route::post('/productos', [ProductoController::class, 'store'])->name('api.productos.store');
Route::post('/editproducto/{id}', [ProductoController::class, 'update'])->name('api.productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('api.productos.destroy');
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('api.productos.show');

//Rutas usuarios

Route::post('/register', [UserController::class, 'register'])->name('api.register');
Route::post('/login', [UserController::class, 'login']);
Route::get('/allusers', [UserController::class, 'allUsers'])->name('api.allusers');
Route::delete('/deleteuser/{id}', [UserController::class, 'deleteUser'])->name('api.deleteuser');
Route::get('user/{id}', [UserController::class, 'getUser'])->name('api.getuser');
Route::post('user/{id}', [UserController::class, 'updateUser'])->name('api.updateuser');


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::post('logout', [UserController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
