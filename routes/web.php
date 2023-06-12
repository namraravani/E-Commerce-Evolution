<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;





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

Route::resource('/admin/dashboard/category', CategoryController::class);
Route::post('/admin/dashboard/category', [CategoryController::class,'getCategory'])->name('category.getCategory');




Route::resource('/admin/dashboard/user', UserController::class);
// Route::get('/admin/dashboard/user',[UserController::class,'index']);
Route::post('fetchstate', [CustomerController::class,'fetchstate'])->name('fetchstate');
Route::post('fetchcity', [CustomerController::class,'fetchcity'])->name('fetchcity');;

Route::resource('/admin/dashboard/customer', CustomerController::class);

Route::delete('category/{id}/delete-image', 'CategoryController@deleteImage')->name('category.deleteImage');



//password resets
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


// profile route
Route::get('/dashboard/edit-profile', [UserController::class, 'profile_view'])->name('profile_view');
Route::post('/dashboard/edit-profile', [UserController::class, 'edit_profile'])->name('edit_profile');
Route::post('/dashboard/edit-password', [UserController::class, 'edit_password'])->name('edit_password');

