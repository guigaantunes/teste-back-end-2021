<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
    });
