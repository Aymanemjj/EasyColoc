<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpencesController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/create-house', function(){
    return redirect()->route("house.create");
});

Route::patch('/house/details/{id}',[HouseController::class, 'exit'])->name('house.exit');
Route::get('/house/details/{id}',[HouseController::class, 'show'])->name('house.show');

Route::get('/house/{id}/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/house/{id}/category/create', [CategoryController::class, 'store'])->name('category.store');


Route::get('/house/{id}/expence/create', [ExpencesController::class, 'create'])->name('expence.create');
Route::post('/house/{id}/expence/create', [ExpencesController::class, 'store'])->name('expence.store');
Route::get('/house/{id}/expence/edit', [ExpencesController::class, 'edit'])->name('expence.edit');
Route::put('/house/{id}/expence/edit', [ExpencesController::class, 'update'])->name('expence.update');
Route::delete('/house/{id}/', [ExpencesController::class, 'destroy'])->name('expence.destroy');

require __DIR__.'/auth.php';


Route::resource('house', HouseController::class);
Route::resource('category', CategoryController::class);
