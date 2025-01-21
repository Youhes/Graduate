<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('/items/index');
    Route::post('/store', [App\Http\Controllers\ItemController::class, 'store'])->name('/items/store');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/show/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('/items/show/{id}');
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('/items/edit/{id}');
    Route::post('/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('/items/{id}');
    Route::delete('/destroy/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.destroy');
});
