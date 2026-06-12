<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CrmTaskController;
use App\Http\Controllers\CrmNoteController;
use App\Http\Controllers\CrmActivityController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('accounts', AccountController::class);
    Route::resource('contacts', ContactController::class);
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])
        ->name('leads.convert');
    Route::resource('leads', LeadController::class);
    Route::resource('opportunities', OpportunityController::class);   
    Route::post('/crm-tasks/{crmTask}/complete', [CrmTaskController::class, 'complete'])
    ->name('crm-tasks.complete');

    Route::resource('crm-tasks', CrmTaskController::class);

    Route::post('/crm-notes', [CrmNoteController::class, 'store'])
        ->name('crm-notes.store');

    Route::delete('/crm-notes/{crmNote}', [CrmNoteController::class, 'destroy'])
        ->name('crm-notes.destroy');

    Route::post('/crm-activities', [CrmActivityController::class, 'store'])
        ->name('crm-activities.store');

    Route::delete('/crm-activities/{crmActivity}', [CrmActivityController::class, 'destroy'])
        ->name('crm-activities.destroy');
});

require __DIR__.'/auth.php';
