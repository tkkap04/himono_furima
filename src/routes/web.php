<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;


Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    // マイページ表示
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

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

    // 決済処理
    Route::post('/payment/card', [PaymentController::class, 'cardProcess'])->name('payment.card');
    Route::post('/payment/noncard', [PaymentController::class, 'nonCardProcess'])->name('payment.noncard');

    // 決済成功後のページ
    Route::get('/success/card', [PaymentController::class, 'successCard'])->name('purchase.success.card');
    Route::get('/success/noncard', [PaymentController::class, 'successNonCard'])->name('purchase.success.noncard');

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

Route::group(['middleware' => 'admin'], function() {
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('admin')->name('comments.destroy');
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/list', [AdminController::class, 'showList'])->name('admin.email.list');
    Route::post('/admin/send-email/{user}', [AdminController::class, 'sendEmail'])->name('admin.sendEmail');
    Route::post('/admin/send-email-all', [AdminController::class, 'sendEmailAll'])->name('admin.sendEmailAll');
    Route::get('/admin/edit-email', [AdminController::class, 'editEmail'])->name('admin.editEmail');
    Route::post('/admin/update-email', [AdminController::class, 'updateEmail'])->name('admin.updateEmail');
});