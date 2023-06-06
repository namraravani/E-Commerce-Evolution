<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/admin/login', [AuthController::class,'login']);
Route::get('/admin/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
Route::get('/admin/register', [AuthController::class,'register']);


Route::post('/admin/login',[AuthController::class,'validateform'])->name('validateform');
Route::post('/admin/register',[AuthController::class,'validateform_register'])->name('validateform_register');
Route::get('/admin/logout',[AuthController::class,'logout'])->name('logout');

Route::resource('category', CategoryController::class);
Route::resource('user', UserController::class);

Route::delete('category/{id}/delete-image', 'CategoryController@deleteImage')->name('category.deleteImage');
















