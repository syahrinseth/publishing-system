<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// Manuscript Module

Route::get('/manuscript-create', [App\Http\Controllers\ManuscriptController::class, 'create'])->name('manuscript.create');

Route::get('/manuscripts', [App\Http\Controllers\ManuscriptController::class, 'index'])->name('manuscript.index');

Route::get('/manuscripts/{id}/edit', [App\Http\Controllers\ManuscriptController::class, 'edit'])->name('manuscript.edit');

// Journal Module

Route::get('/journals', [App\Http\Controllers\JournalController::class, 'index'])->name('journal.index');

Route::get('/journals/{id}', [App\Http\Controllers\JournalController::class, 'show'])->name('journal.show');

Route::get('/journals/{id}/edit', [App\Http\Controllers\JournalController::class, 'edit'])->name('journal.edit');

// User Module

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');