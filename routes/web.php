<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DatasheetController;
use App\Http\Controllers\LanguageSelectorController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')
    ->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    // Learners Section Routes
    Route::resource('learners', LearnerController::class);

    // Operators Section Routes
    Route::resource('operators', OperatorController::class);

    // Appointments Section Routes
    Route::resource('appointments', AppointmentController::class);

    // Appointments Section Routes
    Route::resource('learners.datasheets', DatasheetController::class)
        ->except(['index','create','edit'])
        ->shallow();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/locale', LanguageSelectorController::class)
    ->name('locale.update');


require __DIR__.'/auth.php';
