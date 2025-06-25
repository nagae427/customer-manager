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
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

//ログイン関係
Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('guest')->name('login_post');
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // 顧客管理
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/form/{customer?}', [CustomerController::class, 'createOrEdit'])->name('customers.form'); //登録、編集画面
    Route::post('/customers/confirm/{customer?}', [CustomerController::class, 'storeOrUpdateConfirm'])->name('customers.save_confirm'); //登録、編集確認
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers/{customer?}', [CustomerController::class, 'storeOrUpdate'])->name('customers.save'); //登録、編集
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // ユーザー（営業担当者）管理
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/form/{user?}', [UserController::class, 'createOrEdit'])->name('users.form'); //登録、編集画面
    Route::post('/users/confirm/{user?}', [UserController::class, 'storeOrUpdateConfirm'])->name('users.save_confirm'); //登録、編集確認
    Route::post('/users/{user?}', [UserController::class, 'storeOrUpdate'])->name('users.save'); //登録、編集
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
