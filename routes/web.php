<?php

use Inertia\Inertia;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PublicJournalController;

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

# Public Route
Route::get('/', [PublicController::class, 'index'])->name('public.index');

// Journals
Route::get('/journals', [PublicJournalController::class, 'index'])->name('public.journal.index');
Route::get('/journals/{id}', [PublicJournalController::class, 'show'])->name('public.journal.show');

# Private Route
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Inertia::share('auth.user', function () {
        $auth = Auth::user();
        return $auth == null ? null : new UserResource($auth);
    });
    
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

    // Manuscript Module

    Route::get('/manuscript-create', [App\Http\Controllers\ManuscriptController::class, 'create'])->name('manuscript.create');

    Route::post('/manuscript-store', [App\Http\Controllers\ManuscriptController::class, 'store'])->name('manuscript.store');

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

    // Manuscript Types

    // Route::get('manuscript-types', [App\Http\Controllers\ManuscriptController::class, 'indexManuscriptTypes'])->name('manuscript.indexManuscriptType');


    // Journal Module

    Route::get('/journals', [App\Http\Controllers\JournalController::class, 'index'])->name('journal.index');

    Route::get('/journals/{id}', [App\Http\Controllers\JournalController::class, 'show'])->name('journal.show');

    Route::get('/journal-create', [App\Http\Controllers\JournalController::class, 'create'])->name('journal.create');

    Route::post('/journal-store', [App\Http\Controllers\JournalController::class, 'store'])->name('journal.store');

    Route::get('/journals/{id}/edit', [App\Http\Controllers\JournalController::class, 'edit'])->name('journal.edit');

    Route::post('/journals/{id}/update', [App\Http\Controllers\JournalController::class, 'update'])->name('journal.update');

    Route::post('/journals/{id}/destroy', [App\Http\Controllers\JournalController::class, 'destroy'])->name('journal.destroy');

    // User Module

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

    Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

    Route::get('/user-create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');

    Route::get('/user-store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

    Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');

    Route::post('/users/{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

    Route::post('/users/{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

    // Roles

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');

    Route::get('/role-create', [App\Http\Controllers\RoleController::class, 'create'])->name('role.create');

    Route::get('/role-store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');

    Route::get('/roles/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('role.show');

    Route::get('/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');

    Route::post('/roles/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');

    Route::post('/roles/{id}/destroy', [App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');

    // Roles & Permissions

    Route::post('/roles-permissions-update', [App\Http\Controllers\RolePermissionController::class, 'update']);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('setting.update');
});