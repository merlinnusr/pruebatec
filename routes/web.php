<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['role:cliente']], function () {
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/create/{id}', [OrderController::class, 'create'])->name('orders.create');
            Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
            Route::get('/callback/success/{orderId}', [OrderController::class, 'callbackSuccess'])->name('orders.callback.success');
            Route::get('/resume', [OrderController::class, 'resume'])->name('orders.resume');
            Route::get('/confirm_buy', [OrderController::class, 'confirmBuy'])->name('orders.confirm_buy');
        });
    });
    Route::group(['middleware' => ['role:admin|cliente']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });
    Route::group(['middleware' => ['role:admin']], function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        });
    });
});
