<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApparelSizeController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\ProductColorController;
use App\Http\Controllers\API\ProductCategoryController;







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

Route::controller(UserController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');

});


Route::middleware('auth:sanctum')->group( function () {
    Route::resource('apparel_size', ApparelSizeController::class);
    Route::resource('products', ProductController::class);
    Route::resource('color', ColorController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('sub_cat', SubCategoryController::class);
    Route::resource('pro_color', ProductColorController::class);
    Route::resource('pro_cat', ProductCategoryController::class);

});
