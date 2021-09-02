<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/login',[App\Http\Controllers\AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout',[App\Http\Controllers\AuthController::class, 'logout']);
    });
});

Route::prefix('user')->group(function () {
    Route::post('/create', [App\Http\Controllers\AuthController::class, 'create']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/listar', [App\Http\Controllers\UserController::class, 'listAll']);
        Route::get('/listar/{param}', [App\Http\Controllers\UserController::class, 'list']);
    });
});

Route::prefix('account')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('/pessoal', [App\Http\Controllers\AccountController::class, 'createPessoal']);
        Route::post('/empresarial', [App\Http\Controllers\AccountController::class, 'createEmpresarial']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/accounts/{id}', [App\Http\Controllers\AccountController::class, 'listAccounts']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/transaction', [App\Http\Controllers\TransactionController::class, 'createTransaction']);
});