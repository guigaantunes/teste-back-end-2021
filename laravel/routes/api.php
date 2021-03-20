<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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

    Route::post('login', [UserController::class,'authenticate']);
    Route::post('register', [UserController::class,'register']);

    Route::group(['middleware' => ['jwt.verify']], function() {
        /**
         * Rotas de Usuario
         */
        Route::get('auth/user',[UserController::class,'getAuthenticatedUser']);
        Route::get('auth/logout', [UserController::class,'logout']);
        Route::post('auth/refresh', [UserController::class,'refresh']);
        Route::get('auth/me', [UserController::class,'me']);
        /**
         * Rotas de produto
         */
        Route::post('product', [ProductController::class,'store']);
        Route::get('product', [ProductController::class,'index']);
        Route::get('product/{id}', [ProductController::class,'show']);
        Route::delete('product/{id}', [ProductController::class,'destroy']);
        Route::put('product/{id}', [ProductController::class,'update']);
    });
