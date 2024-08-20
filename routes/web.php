<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SocialiteController;
use App\Http\Middleware\CheckMenuPermission;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProviderTypeController;


require __DIR__.'/auth.php';

Route::get('/', function () {  return redirect('/login'); })->name('welcome');
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    

    
    


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pago', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/failure', [PaymentController::class, 'failure'])->name('payment.failure');
    Route::get('/pending', [PaymentController::class, 'pending'])->name('payment.pending');
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');
});




Route::middleware(['auth', CheckMenuPermission::class])->group(function () {
    //Route::resource('menus', MenuController::class);
    //Route::resource('questions', QuestionController::class);
    //Route::resource('provider-types', ProviderTypeController::class);
});













