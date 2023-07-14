<?php

use App\Models\Child;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $children = Child::all();
    return view('child.create',compact('children'));
});

Route::prefix('child')->name('child.')->group(function(){
    Route:: delete('delete/{id}',[\App\Http\Controllers\ChildController::class,'destroy'])->name('destroy');
    Route::get('/create',[\App\Http\Controllers\ChildController::class,'create'])->name('create');
    Route:: post('',[\App\Http\Controllers\ChildController::class,'store'])->name('store');
    Route::get('',[\App\Http\Controllers\ChildController::class,'index'])->name('index');
    Route:: get('/{id}',[\App\Http\Controllers\ChildController::class,'show'])->name('show');
    Route:: get('/{id}/edit',[\App\Http\Controllers\ChildController::class,'edit'])->name('edit');
    Route:: put('/{id}',[\App\Http\Controllers\ChildController::class,'update'])->name('update');
});
