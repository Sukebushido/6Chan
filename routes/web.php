<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/{boardName}', [BoardController::class, 'index'])->name('board');
Route::get('/test', [ThreadController::class, 'index'])->name('test');

Route::group(['prefix' => '/{boardName}'], function(){
    Route::get('/', [BoardController::class, 'index'])->name('board');
    Route::get('/{threadId}/{threadTitle}', [ThreadController::class, 'index'])->name('thread');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::middleware(['throttle:post'])->group(function(){
        Route::post('/imgboard', [PostController::class, 'index'])->name('post');
    });
}); 


