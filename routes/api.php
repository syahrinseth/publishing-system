<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ManuscriptController;
use App\Http\Controllers\NotificationController;
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
    Route::controller(UserController::class)->group(function() {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });

    # Manuscript

    Route::get('/manuscripts', [ManuscriptController::class, 'index'])->name('api.manuscript.index');

    Route::get('/manuscripts/{id}', [ManuscriptController::class, 'edit'])->name('api.manuscript.edit');

    Route::put('/manuscripts/{id}', [ManuscriptController::class, 'update'])->name('api.manuscript.update');

    Route::delete('/manuscripts/{id}', [ManuscriptController::class, 'destroy'])->name('api.manuscript.destroy');

    # Manuscript Comments
    Route::get('/manuscripts/{id}/comments', [ManuscriptController::class, 'indexComment'])->name('api.manuscript.comment.index');
    Route::post('/manuscripts/{id}/comments', [ManuscriptController::class, 'storeComment'])->name('api.manuscript.comment.store');

    # Manuscript Attach

    Route::get('/manuscripts/{id}/attach-files', [ManuscriptController::class, 'indexAttachFile'])->name('api.manuscript.attachFile.index');

    Route::get('/manuscripts/{id}/attach-files/{attachFileId}', [ManuscriptController::class, 'showAttachFile'])->name('api.manuscript.attachFile.show');

    Route::post('/manuscripts/{id}/attach-files', [ManuscriptController::class, 'storeAttachFile'])->name('api.manuscript.attachFile.store');

    Route::put('/manuscripts/{id}/attach-files/{attachFilesId}', [ManuscriptController::class, 'updateAttachFile'])->name('api.manuscript.attachFile.update');

    Route::delete('/manuscripts/{id}/attach-files/{attachFilesId}', [ManuscriptController::class, 'destroyAttachFile'])->name('api.manuscript.attachFile.destroy');

    # Manuscript Attach Comments
    Route::get('/manuscripts/{id}/attach-files/{attachFilesId}/comments', [ManuscriptController::class, 'indexAttachFileComment'])->name('api.manuscript.attachFile.comment.index');
    Route::post('/manuscripts/{id}/attach-files/{attachFilesId}/comments', [ManuscriptController::class, 'storeAttachFileComment'])->name('api.manuscript.attachFile.comment.store');

    # Manuscript.attachFile Type

    // Route::get('manuscript-types', [App\Http\Controllers\ManuscriptController::class, 'indexManuscriptTypes'])->name('api.manuscript.indexManuscriptType');

    # Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('api.setting.index');
    Route::put('/settings', [SettingControlle::class, 'update'])->name('api.setting.update');

    // Journals
    Route::controller(JournalController::class)->group(function () {
        Route::get('/journals/{id}/manuscripts', 'indexManuscript')->name('api.journal.manuscript');
    });

    Route::controller(NotificationController::class)->group(function() {
        Route::put('/notifications/mark-as-read', 'markAsRead')->name('notification.markAsRead');
    });

});
