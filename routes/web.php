<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\MailingListController;


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


require __DIR__.'/auth.php';
