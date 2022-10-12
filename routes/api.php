<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserTrayController;

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
Route::post('signup',[AuthController::class, 'signup']);
Route::post('signin',[AuthController::class, 'signin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('list-category', [FoodCategoryController::class,'listCategory']);
Route::get('product-filter/{id}', [ProductController::class, 'productFilter']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::resource('category', FoodCategoryController::class);
    Route::post('product-upload', [ProductController::class, 'productUpload']);
    Route::resource('product', ProductController::class);
    Route::post('user-tray', [UserTrayController::class, 'userTray']);
    Route::get('user-list-tray', [UserTrayController::class, 'userListTray']);
    
});