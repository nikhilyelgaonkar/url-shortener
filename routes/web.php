<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UrlRedirectController;
use App\Http\Controllers\UserController;

// Redirect home page to dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // URL Management
    Route::resource('urls', UrlController::class);


    // User Management
    Route::resource('users', UserController::class);

});

Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::resource('companies', CompanyController::class)
        ->except(['show']);
});

Route::middleware(['auth', 'verified', 'role:superadmin,admin'])->group(function () {
    Route::resource('invitations', InvitationController::class)
        ->only(['index', 'create', 'store']);
});


Route::get('/invitations/{token}/accept', [InvitationController::class, 'showAcceptForm'])
    ->name('invitations.accept');

Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])
    ->name('invitations.accept.store');

Route::middleware(['auth', 'verified', 'role:superadmin,member'])->group(function () {
    Route::get('/urls/create', [UrlController::class, 'create'])
        ->name('urls.create');

    Route::post('/urls', [UrlController::class, 'store'])
        ->name('urls.store');
});


Route::get('/r/{code}', [UrlRedirectController::class, 'redirect'])
    ->name('url.redirect');


Route::middleware(['auth', 'verified', 'role:admin,member'])->group(function () {
    Route::get('/urls', [UrlController::class, 'index'])
        ->name('urls.index');
});

// Profile Management
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

// Authentication routes provided by Breeze
require __DIR__.'/auth.php';
