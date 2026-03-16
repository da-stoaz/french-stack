<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');

Route::get('/book', [BookingController::class, 'show'])->name('book.show');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/book/slots', [BookingController::class, 'slots'])->name('book.slots');
Route::get('/booking/confirmed', [BookingController::class, 'confirmed'])->name('booking.confirmed');
