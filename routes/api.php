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
Route::post('/logout', [APIController::class, 'logout']);
Route::post('/mobile-exists', [APIController::class, 'alreadyExists']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/district', [APIController::class, 'district']);
    Route::get('/applicant-types', [APIController::class, 'applicantType']);
    Route::get('/caste-category', [APIController::class, 'CasteCategory']);
    Route::post('/profile-update',[APIController::class,'profileUpdate']);
    Route::post('/language-update', [APIController::class, 'languageUpdate']);
    Route::get('/schemes', [APIController::class, 'fetchSchemes']);
    Route::get('/fetch-profile', [APIController::class, 'fetchProfile']);
    Route::post('/profile-personal', [APIController::class, 'personalInfoUpdate']);
    Route::post('/profile-address', [APIController::class, 'AddressUpdate']);
    Route::get('/market-price', [APIController::class, 'fetchMarketRate']);
    Route::get('/market-district', [APIController::class, 'fetchMarketDistrict']);
    Route::get('/market-commodity', [APIController::class, 'fetchCommodity']);
    Route::get('/market-mandi', [APIController::class, 'fetchMarket']);
    Route::get('/featured-scheme', [APIController::class, 'fetchFeaturedScheme']);    
    Route::get('/fetch-video',[APIController::class, 'fetchVideos']);
    Route::get('/fetch-lands', [APIController::class, 'fetchFarmerLand']);    
    Route::get('/fetch-banks',[APIController::class, 'fetchFarmerBank']);
    Route::get('/delete-land',[APIController::class, 'deleteFarmerLand']);
    Route::post('/save-land', [APIController::class, 'saveFarmerLand']);
    Route::post('/save-bank', [APIController::class, 'saveFarmerBank']);
    Route::post('/applied-scheme', [APIController::class, 'appliedScheme']);
    Route::get('/fetch-applied-scheme',[APIController::class, 'fetchSchemeStatus']);
});
Route::get('/fetchallschemes',[APIController::class, 'fetchAllSchemes']);
// Route::post('/register', [API/APIController::class, 'register']);
