<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicJournalController;

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

// Public Route
Route::get('/journals', [PublicJournalController::class, 'index'])->name('api.public.journal.index');
Route::get('/journals/{id}', [PublicJournalController::class, 'show'])->name('api.public.journal.show');

// Private Route
Route::middleware('auth:sanctum')->group(function () {

    # User
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    # Manuscript

    Route::get('/manuscripts', [App\Http\Controllers\ManuscriptController::class, 'index'])->name('api.manuscript.index');

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

    // Route::get('manuscript-types', [App\Http\Controllers\ManuscriptController::class, 'indexManuscriptTypes'])->name('api.manuscript.indexManuscriptType');

    # Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('api.setting.index');
    Route::put('/settings', [SettingControlle::class, 'update'])->name('api.setting.update');

});
