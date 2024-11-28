<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Board\BoardController;
use App\Http\Controllers\Produccion\ProduccionController;
use App\Http\Controllers\Log\LogController;
use App\Http\Controllers\Mold\MoldController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;



Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/auth/forgot-password', [AuthController::class, 'sendResetLinkEmail']);

Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/auth/verifyResetToken/{token}', [AuthController::class, 'verifyResetToken']);

Route::middleware('auth:api')->group(function () {
    
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/checkToken', [AuthController::class, 'checkToken']);
    Route::get('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::put('/auth/update/{id}', [AuthController::class, 'update']);
    
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);


    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::get('/boards', [BoardController::class, 'index']);
    Route::post('/boards', [BoardController::class, 'store']);
    Route::get('/boards/{id}', [BoardController::class, 'show']);
    Route::put('/boards/{id}', [BoardController::class, 'update']);
    Route::delete('/boards/{id}', [BoardController::class, 'destroy']);


    
    Route::get('/produccions', [ProduccionController::class, 'index']);
    Route::post('/produccions', [ProduccionController::class, 'store']);
    Route::get('/produccions/{id}', [ProduccionController::class, 'show']);
    Route::put('/produccions/{id}', [ProduccionController::class, 'update']);
    Route::delete('/produccions/{id}', [ProduccionController::class, 'destroy']);

    

    Route::get('/molds', [MoldController::class, 'index']);
    Route::post('/molds', [MoldController::class, 'store']);
    Route::get('/molds/{id}', [MoldController::class, 'show']);
    Route::put('/molds/{id}', [MoldController::class, 'update']);
    Route::delete('/molds/{id}', [MoldController::class, 'destroy']);

    Route::get('/permissions', [PermissionController::class, 'index']);
    
    Route::get('/dashboard', [ReportController::class, 'dashboard']);


    Route::get('/logs', [LogController::class, 'index']);

});
