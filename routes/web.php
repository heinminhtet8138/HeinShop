<?php

use Illuminate\Support\Facades\Route;

Route::get('/',[App\Http\Controllers\FrontController::class, 'shop'])->name('shop');
Route::get('/shop-item/{id}',[App\Http\Controllers\FrontController::class, 'shopItem'])->name('shop-item');

Route::get('item-carts',[App\Http\Controllers\FrontController::class, 'carts'])->name('item-carts.carts');

Route::post('order-now',[App\Http\Controllers\FrontController::class, 'orderNow'])->name('orderNow');

Route::get('item-categories/{category_id}',[App\Http\Controllers\FrontController::class, 'itemCategory'])->name('item.categories');

Route::group(['middleware'=>['auth','role:Super Admin|Admin'],'prefix'=>'backend','as'=>'backend.'],function(){
    Route::get('/',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('items',App\Http\Controllers\Admin\ItemController::class);
    Route::resource('users',App\Http\Controllers\Admin\UserController::class)->middleware('role:Super Admin');

    Route::get('orders',[App\Http\Controllers\Admin\OrderController::class, 'orders'])->name('orders');
    Route::get('orderAccept',[App\Http\Controllers\Admin\OrderController::class, 'orderAccept'])->name('orderAccept');
    Route::get('orderComplete',[App\Http\Controllers\Admin\OrderController::class, 'orderComplete'])->name('orderComplete');
    Route::get('orders/{voucher}', [App\Http\Controllers\Admin\OrderController::class, 'orderDetail'])->name('orders.detail');

    Route::put('orders/{voucher}', [App\Http\Controllers\Admin\OrderController::class, 'status'])->name('orders.status');
    


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
