<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
route::post('login',[AuthController::class,'login']);



Route::middleware('auth:api')->group(function(){
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('article/{id}', [ArticleController::class, 'get']);
    Route::post('article/add', [ArticleController::class, 'post']);
    Route::post('article/edit/{id}', [ArticleController::class, 'update']);
    Route::get('article/delete/{id}', [ArticleController::class, 'destroy']);
});

Route::get('articles', [ArticleController::class, 'index']);

