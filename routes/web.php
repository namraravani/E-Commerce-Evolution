<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;




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

// Auth-Routes
Route::get('/admin/login', [AuthController::class,'login']);
Route::get('/admin/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
Route::get('/admin/register', [AuthController::class,'register']);
Route::post('/admin/login',[AuthController::class,'validateform'])->name('validateform');
Route::post('/admin/register',[AuthController::class,'validateform_register'])->name('validateform_register');
Route::get('/admin/logout',[AuthController::class,'logout'])->name('logout');


// Category-Routes
Route::prefix('/admin/dashboard/category')->group(function () {
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/get', [CategoryController::class,'getCategory'])->name('category.getCategory');
});




//customer-Routes

Route::prefix('/admin/dashboard/customer')->group(function () {
    Route::get('', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{customer}', [CustomerController::class,'show'])->name('customer.show');
    Route::get('/{customer}/edit', [CustomerController::class,'edit'])->name('customer.edit');
    Route::put('/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::post('/get', [CustomerController::class,'getCustomer'])->name('customer.getCustomer');
});
// Route::resource('/admin/dashboard/customer', CustomerController::class);
Route::post('admin/dashboard/fetchstate', [CustomerController::class,'fetchstate'])->name('fetchstate');
Route::post('admin/dashboard/fetchcity', [CustomerController::class,'fetchcity'])->name('fetchcity');

//user-routes

Route::resource('/admin/dashboard/user', UserController::class);
Route::post('/admin/dashboard/user/get', [UserController::class,'getUser'])->name('user.getUser');

Route::resource('admin/dashboard/product', ProductController::class);
Route::post('/admin/dashboard/product/get', [ProductController::class,'getProduct'])->name('product.getProduct');
// Route::view('/admin/dashboard/product', [ProductController::class,'index'])->name('');


//password resets
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


// profile route
Route::get('/dashboard/edit-profile', [UserController::class, 'profile_view'])->name('profile_view');
Route::post('/dashboard/edit-profile', [UserController::class, 'edit_profile'])->name('edit_profile');
Route::post('/dashboard/edit-password', [UserController::class, 'edit_password'])->name('edit_password');


// Route::delete('/product/{productId}/image/{imageId}',[ProductController::class,'deleteImage'])->name('product.image.delete');
// Route::delete('/product/{productId}/delete-thumbnail', 'ProductController@deleteThumbnail')->name('product.deleteThumbnail');




