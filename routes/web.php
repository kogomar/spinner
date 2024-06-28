<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\VerifyTokenPageAccess;
use App\Http\Middleware\VerifyTokenRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
})->name('register.form');

Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('game/{token}', [GameController::class, 'show'])
    ->middleware(VerifyTokenPageAccess::class)
    ->name('game');

Route::middleware([VerifyTokenRequest::class])->group(function () {
    Route::post('game/spin', [GameController::class, 'spin'])->name('spin');
    Route::post('game/spin-history', [GameController::class, 'spinHistory'])->name('spinHistory');
    Route::post('token/generate', [TokenController::class, 'generateUrl'])->name('generateUrl');
    Route::post('token/{token}/status/{status}', [TokenController::class, 'changeStatus'])->name('changeUrlStatus');
});
