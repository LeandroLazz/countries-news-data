<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;


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

/**
 * Route for retrieving a list of all countries
 * 
 */
Route::get('/countries', [CountryController::class, 'index']);

/**
 * Route for retrieving a selected country by the given country code
 * 
 */
Route::get('/countries/{code}', [CountryController::class, 'show']);

/**
 * Route for add a new category for a specific country 
 * 
 */
Route::post('/countries/{code}/categories/{categoryName}', [CountryController::class, 'addCategory']);
