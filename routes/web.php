<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\FamilyTreeController;
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

Route::get('/', function () {
    return redirect('/family-trees');
});

Route::prefix('family-trees')->group(function () {
    Route::get('/', [FamilyTreeController::class, 'getAll'])->name('family-trees');
    Route::get('/{tree}', [FamilyTreeController::class, 'getOne'])->name('family-tree');
});

Route::prefix('people')->group(function () {
    Route::get('/{person}', [PeopleController::class, 'getOne'])->name('person');
});
