<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [ApiAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('logout', [ApiAuthController::class, 'logout']);
    Route::controller(ProductController::class)->group(function() {
        Route::middleware('CheckApiRole:admin')->group(function () {
            Route::get('/allProduct', 'getAllProducts');
        });

        Route::middleware('CheckApiRole:admin,seller')->group(function () {
            Route::post('/addNewProduct', 'addNewProduct');
            Route::post('/updateProduct/{id}', 'updateProduct');
            Route::post('/deleteFile', 'deleteFolderAndFiles');
            Route::delete('/deleteProduct/{id}', 'deleteProductData');
        });
    });
});


