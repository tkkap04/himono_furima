<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\ProfileController;


Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    // マイページ表示
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/selling', [MypageController::class, 'selling'])->name('mypage.selling');
    Route::get('/mypage/purchased', [MypageController::class, 'purchased'])->name('mypage.purchased');

    // プロフィール編集
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // お気に入り
    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite/{item}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    // コメント
    Route::get('/comments/{id}', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{id}', [CommentController::class, 'store'])->name('comments.store');

    // 購入ページ
    Route::get('/purchase/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/confirm/{id}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');

    // 支払方法変更
    Route::get('/change/method', [ChangeController::class, 'showMethod'])->name('change.method');
    Route::post('/change/method', [ChangeController::class, 'updateMethod'])->name('update.method');

    // 配送先変更
    Route::get('/change/place', [ChangeController::class, 'showPlace'])->name('change.place');
    Route::post('/change/place', [ChangeController::class, 'updatePlace'])->name('update.place');

    // 出品
    Route::get('/sell', [ItemController::class, 'create'])->name('items.store');
    Route::post('/sell', [ItemController::class, 'store'])->name('items');
});