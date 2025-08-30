<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\XMLImportController;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class);

Route::resource('posts', PostController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

Route::get('import/xml', [XMLImportController::class, 'showForm'])->name('import.xml.form');
Route::post('import/xml', [XMLImportController::class, 'processImport'])->name('import.xml.process');

Route::middleware(['auth'])->group(function () {
    Route::get('/menu/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/update', [MenuController::class, 'update'])->name('menu.update');
});

require __DIR__.'/auth.php';
