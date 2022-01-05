<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

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
Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
Route::get('/addcategory', [CategoryController::class, 'addcategory'])->name('addcategory');
Route::post('/savecategory', [CategoryController::class, 'savecategory'])->name('savecategory');
Route::get('/editcategory/{id}', [CategoryController::class, 'editcategory'])->name('editcategory');
Route::post('/updatecategory', [CategoryController::class, 'updatecategory']);
Route::get('/deletecategory/{id}', [CategoryController::class, 'deletecategory'])->name('deletecategory');


Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');

Route::get('/addslider', [SliderController::class, 'addslider'])->name('addslider');
Route::get('/sliders', [SliderController::class, 'sliders'])->name('sliders');
Route::post('/saveslider', [SliderController::class, 'saveslider'])->name('saveslider');
Route::post('/updateslider', [SliderController::class, 'updateslider'])->name('updateslider');

Route::get('/editslider/{id}', [SliderController::class, 'editslider'])->name('editslider');
Route::get('/activateslider/{id}', [SliderController::class, 'activateslider'])->name('activateslider');
Route::get('/deactivateslider/{id}', [SliderController::class, 'deactivateslider'])->name('deactivateslider');
Route::get('/deleteslider/{id}', [SliderController::class, 'deleteslider'])->name('deleteslider');


Route::get('/products', [ProductController::class, 'products'])->name('products');
Route::get('/addproduct', [ProductController::class, 'addproduct'])->name('addproduct');
Route::post('/saveproduct', [ProductController::class, 'saveproduct'])->name('saveproduct');
Route::get('/editproduct/{id}', [ProductController::class, 'editproduct'])->name('editproduct');
Route::post('/updateproduct', [ProductController::class, 'updateproduct'])->name('updateproduct');
Route::get('/deleteproduct/{id}', [ProductController::class, 'deleteproduct'])->name('deleteproduct');
Route::get('/activateproduct/{id}', [ProductController::class, 'activateproduct'])->name('activateproduct');
Route::get('/deactivateproduct/{id}', [ProductController::class, 'deactivateproduct'])->name('deactivateproduct');




Route::get('/', [ClientController::class, 'home'])->name('home');

Route::get('/shop', [ClientController::class, 'shop'])->name('shop');

Route::get('/cart', [ClientController::class, 'cart'])->name('cart');

Route::get('/checkout', [ClientController::class, 'checkout'])->name('checkout');

Route::get('/login', [ClientController::class, 'login'])->name('login');

Route::get('/signup', [ClientController::class, 'signup'])->name('signup');

Route::get('/orders', [ClientController::class, 'orders'])->name('orders');

