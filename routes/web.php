<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyPage\ProfileController;

Auth::routes();
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

// 記事登録画面表示
Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create')->middleware('auth');

// 記事登録処理
Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');

// 記事更新画面表示
Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

// 記事更新処理
Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');

// 記事削除処理
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

// 記事個別表示
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// いいね機能
Route::prefix('articles')->name('articles.')->group(function () {
    Route::put('/{article}/like', [ArticleController::class, 'like'])->name('like')->middleware('auth');
    Route::delete('/{article}/like', [ArticleController::class, 'unlike'])->name('unlike')->middleware('auth');
});

// ユーザーページ
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{name}', [UserController::class, 'show'])->name('show');
    Route::get('/{name}/likes', [UserController::class, 'likes'])->name('likes');
    Route::get('/{name}/followings', [UserController::class, 'followings'])->name('followings');
    Route::get('/{name}/followers', [UserController::class, 'followers'])->name('followers');
    Route::middleware('auth')->group(function () {
        Route::put('/{name}/follow', [UserController::class, 'follow'])->name('follow');
        Route::delete('/{name}/follow', [UserController::class, 'unfollow'])->name('unfollow');
    });
});

Route::prefix('mypage')->namespace('MyPage')->middleware('auth')->group(function () {
    Route::get('edit-profile', [ProfileController::class, 'showProfileEditForm'])->name('mypage.edit-profile');
    Route::post('edit-profile', [ProfileController::class, 'editProfile'])->name('mypage.edit-profile');
});


