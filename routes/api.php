<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [APIController::class, 'login']);
Route::post('/register', [APIController::class, 'register']);
Route::post('/mobile-exists', [APIController::class, 'alreadyExists']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/district', [APIController::class, 'district']);
    Route::get('/applicant-types', [APIController::class, 'applicantType']);
    Route::get('/caste-category', [APIController::class, 'CasteCategory']);
    Route::post('/profile-update',[APIController::class,'profileUpdate']);
    Route::post('/language-update', [APIController::class, 'languageUpdate']);
    Route::get('/schemes', [APIController::class, 'fetchSchemes']);
    Route::get('/fetch-profile', [APIController::class, 'fetchProfile']);
});
// Route::post('/register', [API/APIController::class, 'register']);
