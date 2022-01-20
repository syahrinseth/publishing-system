<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Manuscript

Route::post('/manuscripts', [App\Http\Controllers\ManuscriptController::class, 'store'])->name('api.manuscript.index');

Route::get('/manuscripts/{id}', [App\Http\Controllers\ManuscriptController::class, 'edit'])->name('api.manuscript.edit');

Route::put('/manuscripts/{id}', [App\Http\Controllers\ManuscriptController::class, 'update'])->name('api.manuscript.update');

Route::delete('/manuscripts/{id}', [App\Http\Controllers\ManuscriptController::class, 'destroy'])->name('api.manuscript.destroy');

# Manuscript Attach

Route::get('/manuscripts/{id}/attach-files', [App\Http\Controllers\ManuscriptController::class, 'indexAttachFile'])->name('api.manuscript.attachFile.index');

Route::get('/manuscripts/{id}/attach-files/{attachFileId}', [App\Http\Controllers\ManuscriptController::class, 'showAttachFile'])->name('api.manuscript.attachFile.show');

Route::post('/manuscripts/{id}/attach-files', [App\Http\Controllers\ManuscriptController::class, 'storeAttachFile'])->name('api.manuscript.attachFile.store');

Route::put('/manuscripts/{id}/attach-files/{attachFilesId}', [App\Http\Controllers\ManuscriptController::class, 'updateAttachFile'])->name('api.manuscript.attachFile.update');

Route::delete('/manuscripts/{id}/attach-files/{attachFilesId}', [App\Http\Controllers\ManuscriptController::class, 'destroyAttachFile'])->name('api.manuscript.attachFile.destroy');

# Manuscript Type

Route::get('manuscript-types', [App\Http\Controllers\ManuscriptController::class, 'indexManuscriptTypes'])->name('api.manuscript.indexManuscriptType');
