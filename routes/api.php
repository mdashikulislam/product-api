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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('product',[\App\Http\Controllers\ProductController::class,'index'])->middleware('api.secret');
Route::get('barcode',[\App\Http\Controllers\ProductController::class,'barcode'])->middleware('api.secret');
Route::post('product/create',[\App\Http\Controllers\ProductController::class,'create'])->middleware('api.secret');
Route::post('product/update/{id}',[\App\Http\Controllers\ProductController::class,'update'])->middleware('api.secret');
Route::get('product/delete/{id}',[\App\Http\Controllers\ProductController::class,'delete'])->middleware('api.secret');
