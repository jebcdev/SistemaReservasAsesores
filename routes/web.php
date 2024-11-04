<?php

use App\Http\Controllers\_SiteController;
use App\Http\Controllers\Modules\Admin\AdminReservationController;
use App\Http\Controllers\Modules\Admin\AdminUserController;
use App\Http\Controllers\Modules\Consultant\ConsultantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', _SiteController::class)->name('index');


Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('/', [_SiteController::class, 'admin'])->name('admin.index');

    Route::resource('/users', AdminUserController::class)->names('admin.users');

    Route::resource('/reservations',AdminReservationController::class)->except(['show'])->names('admin.reservations');

    Route::get('/reservations-calendar',[AdminReservationController::class,'calendar'])->name('admin.reservations.calendar');

    Route::get('/getAllReservations',[AdminReservationController::class,'getAllReservations'])->name('admin.getAllReservations');
});

Route::prefix('/consultants')->middleware(['auth','consultant'])->group(function () {

    Route::get('/', [ConsultantController::class,'index'])->name('consultants.index');

    Route::get('/create', [ConsultantController::class,'create'])->name('consultants.create');

    Route::post('/', [ConsultantController::class,'store'])->name('consultants.store');

    Route::get('/{reservation}/edit', [ConsultantController::class,'edit'])->name('consultants.edit');

    Route::patch('/{reservation}', [ConsultantController::class,'update'])->name('consultants.update');

    Route::delete('/{reservation}', [ConsultantController::class,'destroy'])->name('consultants.destroy');
    
    Route::get('/getAllReservations',[ConsultantController::class,'getAllReservations'])->name('consultants.getAllReservations');

    Route::get('/reservations-calendar',[ConsultantController::class,'calendar'])->name('consultants.reservations.calendar');
});












/* Auth | System | Routes */
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [_SiteController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
