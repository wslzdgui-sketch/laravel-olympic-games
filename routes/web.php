<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisciplineController;

Route::get('/', [DisciplineController::class, 'index']);