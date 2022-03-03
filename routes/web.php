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

Route::post('/manuscripts/{id}/update', [App\Http\Controllers\ManuscriptController::class, 'update'])->name('manuscript.update');

Route::post('/manuscripts/{id}/destroy', [App\Http\Controllers\ManuscriptController::class, 'destroy'])->name('manuscript.destroy');

Route::get('/manuscripts/{id}/download', [App\Http\Controllers\ManuscriptController::class, 'download'])->name('manuscript.download');

// Manuscript Attach Files
Route::get('/manuscripts/{id}/attach-files', [App\Http\Controllers\ManuscriptController::class, 'indexAttachFile'])->name('manuscript.attachFile.index');

Route::get('/manuscripts/{id}/attach-files/{attachFileId}', [App\Http\Controllers\ManuscriptController::class, 'showAttachFile'])->name('manuscript.attachFile.show');

Route::post('/manuscripts/{id}/attach-files', [App\Http\Controllers\ManuscriptController::class, 'storeAttachFile'])->name('manuscript.attachFile.store');

Route::post('/manuscripts/{id}/attach-files/{attachFilesId}/update', [App\Http\Controllers\ManuscriptController::class, 'updateAttachFile'])->name('manuscript.attachFile.update');

Route::delete('/manuscripts/{id}/attach-files/{attachFilesId}', [App\Http\Controllers\ManuscriptController::class, 'destroyAttachFile'])->name('manuscript.attachFile.destroy');

Route::get('/manuscripts/{id}/attach-files/{attachFileId}/download', [App\Http\Controllers\ManuscriptController::class, 'downloadAttachFile'])->name('manuscript.downloadManuscriptAttach');


// Journal Module

Route::get('/journals', [App\Http\Controllers\JournalController::class, 'index'])->name('journal.index');

Route::get('/journals/{id}', [App\Http\Controllers\JournalController::class, 'show'])->name('journal.show');

Route::get('/journals/{id}/edit', [App\Http\Controllers\JournalController::class, 'edit'])->name('journal.edit');

// User Module

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

Route::get('/user-create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');

Route::get('/user-store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');

Route::post('/users/{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

Route::post('/users/{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');