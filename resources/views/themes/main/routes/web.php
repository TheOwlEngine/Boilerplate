<?php

use Illuminate\Support\Facades\Route;
use Themes\main\controllers\PageController;

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

Route::middleware(['web'])->group(static function () {

    /**
     * General
     */
    Route::get('/', [ PageController::class, 'home' ])->name('home');

    /**
     * English Route
     */
    Route::prefix('articles')->group(function() {
        Route::get('/', [ PageController::class, 'article' ])->name('article_en');
        Route::get('/{slug}', [ PageController::class, 'articleDetail' ])->name('article_detail_en');
    });
    Route::get('/about', [ PageController::class, 'about' ])->name('about_en');

    /**
     * Indonesian Route
     */
    Route::prefix('artikel')->group(function() {
        Route::get('/', [ PageController::class, 'article' ])->name('article_id');
        Route::get('/{slug}', [ PageController::class, 'articleDetail' ])->name('article_detail_id');
    });
    Route::get('/tentang', [ PageController::class, 'about' ])->name('about_id');

    /**
     * Route Action
     */
    Route::get('/switch/{language}', [ PageController::class, 'switch' ])->name('switch');
    Route::post('/subscribe', [ PageController::class, 'subscribe' ])->name('subscribe');

});
