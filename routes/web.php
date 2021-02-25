<?php

use App\Http\Controllers\BlackjackController;
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

Route::get('/', [BlackjackController::class, 'index'])->name('index');
Route::post('/create-new-game', [BlackjackController::class, 'create'])->name('createNewGame');
Route::get('/game', [BlackjackController::class, 'show'])->name('game');
Route::post('/hit', [BlackjackController::class, 'hit'])->name('hit');
Route::post('/stand', [BlackjackController::class, 'stand'])->name('stand');
Route::post('/new-round', [BlackjackController::class, 'newRound'])->name('newRound');

Route::get('500', [ErrorController::class,'fatal'])->name('500');
