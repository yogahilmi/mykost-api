<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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

Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('signup', [UserController::class, 'signup'])->name('signup');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('create', [DashboardController::class, 'create'])->name('create');
Route::get('edit/{id}', [DashboardController::class, 'edit'])->name('edit');
Route::post('store', [DashboardController::class, 'store'])->name('store');
Route::put('update/{id}', [DashboardController::class, 'update'])->name('update');
Route::delete('delete/{id}', [DashboardController::class, 'delete'])->name('delete');
