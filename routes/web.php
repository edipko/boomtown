<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\MailingListController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GigLeadController;
use App\Http\Controllers\GigLeadAdminController;

Route::middleware('auth')->group(function () {
    Route::resource('venues', VenueController::class);
    Route::resource('events', EventController::class);
});

Route::get('/', [PublicPageController::class, 'index'])->name('public.home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::view('/privacy', 'privacy')->name('privacy');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/mailing-list', [MailingListController::class, 'index'])->name('mailing-list.index');
    Route::delete('/dashboard/mailing-list/{id}', [MailingListController::class, 'destroy'])->name('mailing-list.destroy');
    Route::post('/dashboard/mailing-list/send', [MailingListController::class, 'sendEmails'])->name('mailing-list.send');
});


// web.php
Route::get('/test-mailing-list', function () {
    return view('test-mailing-list');
});


Route::get('/venue/{id}', [App\Http\Controllers\VenueController::class, 'show'])->name('venue.show');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/content', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/content', [ContentController::class, 'update'])->name('content.update');
});


Route::middleware(['auth'])->group(function () {
    // User Management CRUD Routes
    Route::resource('users', UserController::class)->except(['show']);
});

Route::post('/gig-lead', [GigLeadController::class, 'store'])->name('giglead.store');
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('admin/gigleads', [GigLeadAdminController::class, 'index'])->name('gigleads.index');
    Route::get('admin/gigleads/{gigLead}/edit', [GigLeadAdminController::class, 'edit'])->name('gigleads.edit');
    Route::patch('admin/gigleads/{gigLead}', [GigLeadAdminController::class, 'update'])->name('gigleads.update');
    Route::delete('admin/gigleads/{gigLead}', [GigLeadAdminController::class, 'destroy'])->name('gigleads.destroy');
});

Route::get('/press-kit', function () {
    return view('press-kit');
})->name('press-kit');


require __DIR__.'/auth.php';
