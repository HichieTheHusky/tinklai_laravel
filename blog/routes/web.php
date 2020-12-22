<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('Administratorius')->middleware(['admin', 'auth'])->group(function (){
    Route::get('/Administratorius', [App\Http\Controllers\AdminController::class, 'viewUsers'])->name('viewUsers');
    Route::post('/AtnaujintiUser', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('updateUser');
    Route::delete('/TrintiUser', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/BlokuotiUser', [App\Http\Controllers\AdminController::class, 'blockUser'])->name('blockUser');

});

Route::prefix('Darbuotojas')->middleware(['worker', 'auth'])->group(function (){
    Route::view('/PridetiPreke','addProdcut')->name('addProdcut');
    Route::view('/PridetiPrieda','addAcc')->name('addAcc');
    Route::view('/PridetiBazę','addBase')->name('addBase');
    Route::view('/PridetiStabdi','addBrake')->name('addBrake');
    Route::view('/PridetiSedyne','addSaddle')->name('addSaddle');
    Route::view('/PridetiRatus','addTyre')->name('addTyre');
    Route::post('/createPreke', [App\Http\Controllers\ProductController::class, 'createPreke'])->name('createPreke');
    Route::delete('/TrintiPreke', [App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/KeistiPreke', [App\Http\Controllers\ProductController::class, 'getProduct'])->name('changePreke');
    Route::post('/addPreke', [App\Http\Controllers\ProductController::class, 'addPreke'])->name('addPreke');
    Route::post('/updatePreke', [App\Http\Controllers\ProductController::class, 'updatePreke'])->name('updatePreke');
    Route::post('/PatvirtintiUžsakymą', [App\Http\Controllers\OrderController::class, 'approveOrder'])->name('approveOrder');
});

Route::prefix('Parduotuve')->middleware(['notadmin', 'auth'])->group(function (){
    Route::get('/Prekes', [App\Http\Controllers\ProductController::class, 'viewPrekes'])->name('viewProducts');
    Route::get('/Preke', [App\Http\Controllers\ProductController::class, 'viewPreke'])->name('viewProduct');
    Route::get('/Užsakymai', [App\Http\Controllers\OrderController::class, 'viewOrders'])->name('viewOrders');
    Route::get('/Užsakymas', [App\Http\Controllers\OrderController::class, 'viewOrder'])->name('viewOrder');
});

Route::prefix('Vartotojas')->middleware(['user', 'auth'])->group(function (){
    Route::get('add-to-cart/{id}', [App\Http\Controllers\ProductController::class,'addToCart']);
    Route::view('Krepšelis','cart')->name('cart');
    Route::patch('update-cart', [App\Http\Controllers\ProductController::class,'update'])->name('update-cart');
    Route::delete('remove-from-cart', [App\Http\Controllers\ProductController::class,'remove'])->name('remove-from-cart');
    Route::post('/buyPreke', [App\Http\Controllers\ProductController::class, 'buyPreke'])->name('buyPreke');

    Route::delete('/TrintiUžsakymą', [App\Http\Controllers\OrderController::class, 'deleteOrder'])->name('deleteOrder');
    Route::delete('/TrintiPreke', [App\Http\Controllers\OrderController::class, 'deleteProductOrder'])->name('deleteProductOrder');

    Route::view('PasidarykDvirati','partpicker')->name('partpicker');
    Route::get('/Prekes', [App\Http\Controllers\ProductController::class, 'viewPickerPrekes'])->name('viewPickerProducts');
    Route::get('add-to-picker/{id}', [App\Http\Controllers\ProductController::class,'addPickerPreke']);
    Route::delete('remove-from-picker', [App\Http\Controllers\ProductController::class,'pickerremove'])->name('remove-from-picker');
    Route::post('/buyBike', [App\Http\Controllers\ProductController::class, 'buyBike'])->name('buyBike');


});
