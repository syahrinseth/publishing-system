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


Route::post('/manuscripts', [App\Http\Controllers\ManuscriptController::class, 'store']);

Route::get('/manuscripts/{$id}', [App\Http\Controllers\ManuscriptController::class, 'edit']);

Route::put('/manuscripts/{$id}', [App\Http\Controllers\ManuscriptController::class, 'update']);

Route::delete('/manuscripts/{$id}', [App\Http\Controllers\ManuscriptController::class, 'update']);
