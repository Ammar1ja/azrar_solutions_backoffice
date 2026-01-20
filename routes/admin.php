<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookCallController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


// Route::middleware(['web', 'auth'])->group(function () {
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::resource('/project', ProjectController::class);
Route::resource('/service', ServiceController::class);
Route::resource('/blog', BlogController::class);
Route::resource('/faq', FaqController::class);


Route::get('booking',[BookCallController::class,'index'])->name('book-call.index');
Route::resource('/client', ClientController::class);
Route::resource('country', CountryController::class);



Route::get('home', [HomeController::class, 'edit'])->name('home.edit');
Route::post('home', [HomeController::class, 'update'])->name('home.update');
// });