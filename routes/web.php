<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrganizerAuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [DisciplineController::class, 'index']);
Route::get('/calendrier', [DisciplineController::class, 'calendrier']);
Route::get('/billetterie', [ReservationController::class, 'index']);
Route::post('/reservation', [ReservationController::class, 'store']);
Route::get('/confirmation/{id}', [ReservationController::class, 'confirmation'])->name('reservation.confirmation');

// Organizer Authentication Routes
Route::get('/organizer/login', [OrganizerAuthController::class, 'showLogin'])->name('organizer.login');
Route::post('/organizer/login', [OrganizerAuthController::class, 'login'])->name('organizer.login.post');
Route::get('/organizer/logout', [OrganizerAuthController::class, 'logout'])->name('organizer.logout');

// Organizer Admin Routes (Protected by middleware)
Route::middleware('organizer')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/competitions/create', [AdminController::class, 'createDiscipline'])->name('admin.competitions.create');
    Route::post('/admin/competitions', [AdminController::class, 'storeDiscipline'])->name('admin.competitions.store');
    Route::get('/admin/competitions/{discipline}/edit', [AdminController::class, 'editDiscipline'])->name('admin.competitions.edit');
    Route::put('/admin/competitions/{discipline}', [AdminController::class, 'updateDiscipline'])->name('admin.competitions.update');
    Route::delete('/admin/competitions/{discipline}', [AdminController::class, 'deleteDiscipline'])->name('admin.competitions.delete');
    Route::get('/admin/reservations', [AdminController::class, 'viewReservations'])->name('admin.reservations');
});