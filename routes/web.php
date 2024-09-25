<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/appointments', [PatientController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [PatientController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/dates', [PatientController::class, 'getAvailableDates'])->name('appointments.dates');
    Route::get('/appointments/slots', [PatientController::class, 'getAvailableSlots'])->name('appointments.slots');

});

require __DIR__.'/auth.php';
