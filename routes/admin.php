<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Api\V1\ProjectController;
use Illuminate\Support\Facades\Route;


// Route::middleware(['web', 'auth'])->group(function () {
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');
Route::get('/blogs/all', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/projects/all', [ProjectController::class, 'index'])->name('project.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('project.create');
Route::get('/services/all', [ProjectController::class, 'index'])->name('service.index');
Route::get('/services/create', [ProjectController::class, 'create'])->name('service.create');
// });