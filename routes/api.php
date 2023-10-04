<?php

use App\Http\Controllers\API\Admin\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group( function() {

    /**
    * ADMIN ROUTES
    */
    Route::prefix('admin')->name('admin.')->group( function() {

        Route::prefix('products')->name('products.')->group( function() {
            Route::post('/', [ProductsController::class, 'index'])->name('products');
            Route::post('/store', [ProductsController::class, 'store'])->name('product-store');
            Route::post('/update/{id}', [ProductsController::class, 'update'])->name('product-update');
            Route::get('/destroy/{id}', [ProductsController::class, 'destroy'])->name('product-destroy');
        });

    });

});
