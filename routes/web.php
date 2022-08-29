<?php

use App\Enums\PersonRelationshipType;
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
    return redirect()->route('family-trees');
});

Route::prefix('family-trees')->group(function () {
    Route::get('/', [FamilyTreeController::class, 'getAll'])
        ->name('family-trees');

    Route::get('/{tree}', [FamilyTreeController::class, 'getOne'])
        ->where('tree', '[0-9]+')
        ->name('family-tree');

    Route::get('/add', [FamilyTreeController::class, 'getAdd'])
        ->name('add-family-tree');

    Route::post('/add', [FamilyTreeController::class, 'postAdd'])
        ->name('create-family-tree');
});

Route::prefix('people')->group(function () {
    Route::get('/{person}', [PeopleController::class, 'getOne'])
        ->where('person', '[0-9]+')
        ->name('person');

    Route::get('/add/{person}/{type}', [PeopleController::class, 'getAdd'])
        ->where('person', '[0-9]+')
        ->whereIn('type', collect(PersonRelationshipType::cases())->map(fn (PersonRelationshipType $type) => $type->name)->all())
        ->name('add-person');

    Route::post('/add/{person}/{type}', [PeopleController::class, 'postAdd'])
        ->where('person', '[0-9]+')
        ->whereIn('type', collect(PersonRelationshipType::cases())->map(fn (PersonRelationshipType $type) => $type->name)->all())
        ->name('create-person');
});
