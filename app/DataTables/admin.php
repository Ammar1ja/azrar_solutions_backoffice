<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


// Route::middleware(['web', 'auth'])->group(function () {
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::resource('/project', ProjectController::class);
Route::resource('/service', ServiceController::class);
Route::resource('/blog', BlogController::class);



Route::get('home',[HomeController::class,'edit'])->name('home.edit');
Route::post('home',[HomeController::class,'update'])->name('home.update');
// });