<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrganizerAuthController;
use App\Http\Controllers\AdminController;

// ── Pages publiques ───────────────────────────────────────────────────────────
Route::get('/',            [DisciplineController::class, 'index']);
Route::get('/calendrier',  [DisciplineController::class, 'calendrier'])->name('calendrier');

// ── Billetterie & panier ──────────────────────────────────────────────────────
Route::get('/billetterie',                [ReservationController::class, 'index'])->name('billetterie');
Route::get('/panier',                     [ReservationController::class, 'cart'])->name('panier');
Route::post('/reservation',              [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/confirmation/{id}',          [ReservationController::class, 'confirmation'])->name('reservation.confirmation');

// ── Authentification organisateurs ───────────────────────────────────────────
Route::get('/organizer/login',  [OrganizerAuthController::class, 'showLogin'])->name('organizer.login');
Route::post('/organizer/login', [OrganizerAuthController::class, 'login'])->name('organizer.login.post');
Route::get('/organizer/logout', [OrganizerAuthController::class, 'logout'])->name('organizer.logout');

// ── Espace organisateurs (protégé) ────────────────────────────────────────────
Route::middleware('organizer')->group(function () {
    Route::get('/admin/dashboard',                       [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/tours/create',                    [AdminController::class, 'createTour'])->name('admin.tours.create');
    Route::post('/admin/tours',                          [AdminController::class, 'storeTour'])->name('admin.tours.store');
    Route::get('/admin/tours/{tour}/edit',               [AdminController::class, 'editTour'])->name('admin.tours.edit');
    Route::put('/admin/tours/{tour}',                    [AdminController::class, 'updateTour'])->name('admin.tours.update');
    Route::delete('/admin/tours/{tour}',                 [AdminController::class, 'deleteTour'])->name('admin.tours.delete');
    Route::get('/admin/reservations',                    [AdminController::class, 'viewReservations'])->name('admin.reservations');
});
