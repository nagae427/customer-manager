<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

//初めの '/' へのアクセス
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('users.index');
    }

    return redirect()->route('login');
});

//ログイン関係
Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('guest')->name('login_post');

Route::middleware(['auth'])->group(function () {
    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // ログアウト
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
    
    // 顧客管理
    Route::prefix('customers')->group((function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/edit/{customer?}', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::post('/confirm', [CustomerController::class, 'confirm'])->name('customers.confirm');
        Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
        Route::delete('/destroy/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    }));

    // ユーザー（営業担当者）管理
    Route::prefix('users')->group((function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/show/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{user?}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/confirm/{user}', [UserController::class, 'confirm'])->name('users.confirm');
        Route::post('/delete/{user}', [UserController::class, 'delete'])->name('users.delete');
    }));
});