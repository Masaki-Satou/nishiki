<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\UserController;
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
// Route::middleware('guest')->group(function () {
// });
Route::get('/', [UserController::class, 'welcome'])
->name('welcome');

Route::get('/use', [UserController::class, 'use'])
->name('use');


Route::middleware(['device.access'])->group(function () {
    Route::get('/kani', [UserController::class, 'kani'])
    ->name('kani');

    Route::get('/karaage', [UserController::class, 'karaage'])
    ->name('karaage');

    Route::get('/sushi', [UserController::class, 'sushi'])
    ->name('sushi');


});

// Route::get('/', function () {
//     return view('user.welcome');
// });

// require __DIR__.'/auth.php';
