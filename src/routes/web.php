<?php

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

Route::patch('/house/details/{id}',[HouseController::class, 'show'])->name('house.exit');

Route::get('/house/details/{id}',[HouseController::class, 'show']);

require __DIR__.'/auth.php';


Route::resource('house', HouseController::class);