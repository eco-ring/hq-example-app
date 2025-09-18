<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;

//Route::middleware(['web', 'auth'])->group(function () {
//    // Consent screen
//    Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize'])
//        ->name('passport.authorizations.authorize');
//
//    // Approve
//    Route::post('/oauth/authorize', [ApproveAuthorizationController::class, 'approve'])
//        ->name('passport.authorizations.approve');
//
//    // Deny
//    Route::delete('/oauth/authorize', [DenyAuthorizationController::class, 'deny'])
//        ->name('passport.authorizations.deny');
//});

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
