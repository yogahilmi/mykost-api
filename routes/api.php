<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/kost', [KostController::class, 'index']);
Route::get('/kost/list', [KostController::class, 'getKostList']);
Route::get('/kost/{id}', [KostController::class, 'getKostById']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/kost/create', [KostController::class, 'insertKost']);
    Route::post('/kost/search', [KostController::class, 'searchKost']);
    Route::put('/kost/edit/{id}', [KostController::class, 'updateKost']);
    Route::delete('/kost/delete/{id}', [KostController::class, 'deleteKost']);
});
