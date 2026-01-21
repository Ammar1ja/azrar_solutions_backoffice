<?php

use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\BookCallController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\ProjectCategoriesController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Middleware\AppLocaleMiddleWare;

// Route::apiResource('blogs', BlogController::class);
// Route::apiResource('tags', TagController::class);
// Route::apiResource('categories', CategoryController::class);




Route::middleware((AppLocaleMiddleWare::class))->group(function () {
    // Blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/top', [BlogController::class, 'TopBlogs']);

    Route::get('/blog/{id}', [BlogController::class, 'show']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);
    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/service/{id}', [ServiceController::class, 'show']);
    // Projects
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::get('/project/related/{id}', [ProjectController::class, 'relatedProjects']);

    Route::post('/book-call', BookCallController::class);
    Route::get('/faq', FaqController::class);
    Route::get('/clients', ClientController::class);


});
