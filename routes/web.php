<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleFavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowerController;
use App\Models\UserFollower;
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

Route::get('/', HomeController::class)->name('home');
Route::get('login', [SessionController::class, 'create'])->name('login')
    ->middleware(['guest']);
Route::post('login', [SessionController::class, 'store'])
    ->middleware(['guest']);
Route::delete('login', [SessionController::class, 'destroy'])
    ->middleware(['auth']);
Route::get('articles', [ArticleController::class,'index'])->name('articles.index');
Route::post('articles', [ArticleController::class,'store'])->name('articles.store')
    ->middleware(['auth']);
Route::get('articles/{slug}/edit', [ArticleController::class, 'edit'])->name('articles.edit')
    ->middleware(['auth']);
Route::put('articles/{slug}', [ArticleController::class, 'update'])->name('articles.update')
    ->middleware(['auth']);
Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create')
    ->middleware(['auth']);
Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('register', [UserController::class, 'create'])->name('users.create')
    ->middleware(['guest']);
Route::post('users', [UserController::class, 'store']);
Route::get('settings', [UserController::class, 'edit'])->name('users.edit')
    ->middleware(['auth']);
Route::put('settings', [UserController::class, 'update'])
    ->middleware(['auth']);
Route::get('users/{name}', [UserController::class, 'show'])->name('users.show');
Route::post('articles/{slug}/comments', [CommentController::class, 'store'])
    ->name('articles.comments.store')
    ->middleware(['auth']);
Route::put('comments/{id}', [CommentController::class, 'update'])
    ->name('comments.update')
    ->middleware(['auth']);
Route::delete('comments/{id}', [CommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware(['auth']);
Route::post('article-favorites/{id}', [ArticleFavoriteController::class, 'store'])
    ->name('article-favorites.store')
    ->middleware(['auth']);
Route::delete('article-favorites/{id}', [ArticleFavoriteController::class, 'destroy'])
    ->name('article-favorites.destroy')
    ->middleware(['auth']);
Route::post('user-followers/{id}', [UserFollowerController::class, 'store'])
    ->name('user-followers.store')
    ->middleware(['auth']);
Route::delete('user-followers/{id}', [UserFollowerController::class, 'destroy'])
    ->name('user-followers.destroy')
    ->middleware(['auth']);
