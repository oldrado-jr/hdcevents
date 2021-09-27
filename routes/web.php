<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('event.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');

    Route::prefix('events')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{event}', [EventController::class, 'edit'])->name('edit');
            Route::put('/{event}', [EventController::class, 'update'])->name('update');
            Route::post('/join/{event}', [EventController::class, 'joinEvent'])->name('join');
            Route::delete('/leave/{event}', [EventController::class, 'leaveEvent'])->name('leave');
        });

        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::post('', [EventController::class, 'store'])->name('store');
    });
});

Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard')->middleware('auth');
