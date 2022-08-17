<?php

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
    // return view('welcome');
    if(Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/manage-caste-category','Admin\SettingController@manageCasteCategory')->name('manage-caste-category');
Route::get('/edit-caste-category','Admin\SettingController@editCasteCategory')->name('edit-caste-category');
Route::post('/update-caste-category','Admin\SettingController@updateCasteCategory')->name('update-caste-category');
Route::post('/delete-caste-category','Admin\SettingController@deleteCasteCategory')->name('delete-caste-category');
Route::get('/add-caste-category','Admin\SettingController@addCasteCategory')->name('add-caste-category');
Route::post('/add-caste-category','Admin\SettingController@createCasteCategory')->name('add-caste-category');

// manage applicant type
Route::get('/manage-applicant-type','Admin\SettingController@manageAplicantType')->name('manage-applicant-type');
Route::get('/edit-applicant-type','Admin\SettingController@editAplicantType')->name('edit-applicant-type');
Route::post('/update-applicant-type','Admin\SettingController@updateAplicantType')->name('update-applicant-type');
Route::post('/delete-applicant-type','Admin\SettingController@deleteAplicantType')->name('delete-applicant-type');
Route::get('/add-applicant-type','Admin\SettingController@addAplicantType')->name('add-applicant-type');
Route::post('/add-applicant-type','Admin\SettingController@createAplicantType')->name('add-applicant-type');

// manage district
Route::get('/manage-district','Admin\SettingController@manageDistrict')->name('manage-district');
Route::get('/edit-district','Admin\SettingController@editDistrict')->name('edit-district');
Route::post('/update-district','Admin\SettingController@updateDistrict')->name('update-district');
Route::post('/delete-district','Admin\SettingController@deleteDistrict')->name('delete-district');
Route::get('/add-district','Admin\SettingController@addDistrict')->name('add-district');
Route::post('/add-district','Admin\SettingController@createDistrict')->name('add-district');

// manage village
Route::get('/manage-city','Admin\SettingController@manageCity')->name('manage-city');
Route::get('/edit-city','Admin\SettingController@editCity')->name('edit-city');
Route::post('/update-city','Admin\SettingController@updateCity')->name('update-city');
Route::post('/delete-city','Admin\SettingController@deleteCity')->name('delete-city');
Route::get('/add-city','Admin\SettingController@addCity')->name('add-city');
Route::post('/add-city','Admin\SettingController@createCity')->name('add-city');

// manage tehsil
Route::get('/manage-tehsil','Admin\SettingController@manageTehsil')->name('manage-tehsil');
Route::get('/edit-tehsil','Admin\SettingController@editTehsil')->name('edit-tehsil');
Route::post('/update-tehsil','Admin\SettingController@updateTehsil')->name('update-tehsil');
Route::post('/delete-tehsil','Admin\SettingController@deleteTehsil')->name('delete-tehsil');
Route::get('/add-tehsil','Admin\SettingController@addTehsil')->name('add-tehsil');
Route::post('/add-tehsil','Admin\SettingController@createTehsil')->name('add-tehsil');

// manage scheme category
Route::get('/manage-scheme-category','Admin\SettingController@manageSchemeCategory')->name('manage-scheme-category');
Route::get('/edit-scheme-category','Admin\SettingController@editSchemeCategory')->name('edit-scheme-category');
Route::post('/update-scheme-category','Admin\SettingController@updateSchemeCategory')->name('update-scheme-category');
Route::post('/delete-scheme-category','Admin\SettingController@deleteSchemeCategory')->name('delete-scheme-category');
Route::get('/add-scheme-category','Admin\SettingController@addSchemeCategory')->name('add-scheme-category');
Route::post('/add-scheme-category','Admin\SettingController@createSchemeCategory')->name('add-scheme-category');

// manage scheme sub category
Route::get('/manage-scheme-subcategory','Admin\SettingController@manageSchemeSubCategory')->name('manage-scheme-subcategory');
Route::get('/edit-scheme-subcategory','Admin\SettingController@editSchemeSubCategory')->name('edit-scheme-subcategory');
Route::post('/update-scheme-subcategory','Admin\SettingController@updateSchemeSubCategory')->name('update-scheme-subcategory');
Route::post('/delete-scheme-subcategory','Admin\SettingController@deleteSchemeSubCategory')->name('delete-scheme-subcategory');
Route::get('/add-scheme-subcategory','Admin\SettingController@addSchemeSubCategory')->name('add-scheme-subcategory');
Route::post('/add-scheme-subcategory','Admin\SettingController@createSchemeSubCategory')->name('add-scheme-subcategory');

// manage scheme
Route::get('/manage-scheme','Admin\SettingController@manageScheme')->name('manage-scheme');
Route::get('/edit-scheme','Admin\SettingController@editScheme')->name('edit-scheme');
Route::post('/update-scheme','Admin\SettingController@updateScheme')->name('update-scheme');
Route::post('/delete-scheme','Admin\SettingController@deleteScheme')->name('delete-scheme');
Route::get('/add-scheme','Admin\SettingController@addScheme')->name('add-scheme');
Route::post('/add-scheme','Admin\SettingController@createScheme')->name('add-scheme');

//manage farmer

Route::get('/manage-farmer','Admin\FarmerController@manageFarmers')->name('manage-farmer');
Route::get('/add-farmer','Admin\FarmerController@addFarmer')->name('add-farmer');
Route::post('/add-farmer','Admin\FarmerController@createFarmer')->name('add-farmer');
Route::get('/edit-farmer','Admin\FarmerController@editFarmer')->name('edit-farmer');
Route::post('/update-farmer','Admin\FarmerController@updateFarmer')->name('update-farmer');
Route::post('/delete-farmer','Admin\FarmerController@deleteFarmer')->name('delete-farmer');