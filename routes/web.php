<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventRegistrationController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('events', EventController::class);

    Route::get('/events/{event:slug}/register', [EventRegistrationController::class, 'show'])
        ->name('events.register');
    Route::post('/events/{event:slug}/register', [EventRegistrationController::class, 'store'])
        ->name('events.register.store');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__ . '/auth.php';
