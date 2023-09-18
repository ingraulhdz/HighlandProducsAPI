<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [ProductController::class, 'index'])->name('index');
Route::post('excel', [ProductController::class, 'excel'])->name('excel');
Route::get('toShopify', [ProductController::class, 'toShopify'])->name('toShopify');
Route::get('/api', [ProductController::class, 'api'])->name('api');
Route::get('syncData', [ProductController::class, 'syncData'])->name('syncData');
//Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('shopify', [ProductController::class, 'shopify'])->name('shopify');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

