<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\AssistentController;
use App\Http\Controllers\MondhygienistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PraktijkmanagementController;
use App\Http\Controllers\TandartsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tandarts', [TandartsController::class, 'index'])
    ->name('tandarts.index')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement']);

Route::get('/patient', [PatientController::class, 'index'])
    ->name('patient.index')
    ->middleware(['auth', 'role:patient,praktijkmanagement']);

Route::get('/mondhygienist', [MondhygienistController::class, 'index'])
    ->name('mondhygienist.index')
    ->middleware(['auth', 'role:mondhygienist']);

Route::get('/assistent', [AssistentController::class, 'index'])
    ->name('assistent.index')
    ->middleware(['auth', 'role:assistent']);

Route::get('/praktijkmanagement', [PraktijkmanagementController::class, 'index'])
    ->name('praktijkmanagement.index')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::middleware(['auth', 'role:praktijkmanagement'])->group(function () {
    Route::get('/allergenen', [AllergeenController::class, 'index'])->name('allergenen.index');
    Route::get('/allergenen/create', [AllergeenController::class, 'create'])->name('allergenen.create');
    Route::post('/allergenen', [AllergeenController::class, 'store'])->name('allergenen.store');
    Route::match(['get', 'post'], '/allergenen/{allergeen}/edit', [AllergeenController::class, 'edit'])->name('allergenen.edit');
    Route::put('/allergenen/{allergeen}', [AllergeenController::class, 'update'])->name('allergenen.update');
    Route::delete('/allergenen/{allergeen}', [AllergeenController::class, 'destroy'])->name('allergenen.destroy');
});

Route::delete('/praktijkmanagement/users/{user}', [PraktijkmanagementController::class, 'destroy'])
    ->name('praktijkmanagement.users.destroy')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::match(['get', 'post'], '/praktijkmanagement/users/{user}/edit', [PraktijkmanagementController::class, 'edit'])
    ->name('praktijkmanagement.users.edit')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::patch('/praktijkmanagement/users/{user}/role', [PraktijkmanagementController::class, 'updateRole'])
    ->name('praktijkmanagement.users.role')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
