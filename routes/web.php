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
Route::get('/manage-block','Admin\SettingController@manageTehsil')->name('manage-block');
Route::get('/edit-block','Admin\SettingController@editTehsil')->name('edit-block');
Route::post('/update-tehsil','Admin\SettingController@updateTehsil')->name('update-tehsil');
Route::post('/delete-tehsil','Admin\SettingController@deleteTehsil')->name('delete-tehsil');
Route::get('/add-tehsil','Admin\SettingController@addTehsil')->name('add-tehsil');
Route::post('/add-tehsil','Admin\SettingController@createTehsil')->name('add-tehsil');

// manage scheme category
Route::get('/manage-scheme-category','Admin\SchemeController@manageSchemeCategory')->name('manage-scheme-category');
Route::get('/edit-scheme-category','Admin\SchemeController@editSchemeCategory')->name('edit-scheme-category');
Route::post('/update-scheme-category','Admin\SchemeController@updateSchemeCategory')->name('update-scheme-category');
Route::post('/delete-scheme-category','Admin\SchemeController@deleteSchemeCategory')->name('delete-scheme-category');
Route::get('/add-scheme-category','Admin\SchemeController@addSchemeCategory')->name('add-scheme-category');
Route::post('/add-scheme-category','Admin\SchemeController@createSchemeCategory')->name('add-scheme-category');

// manage scheme sub category
Route::get('/manage-scheme-subcategory','Admin\SchemeController@manageSchemeSubCategory')->name('manage-scheme-subcategory');
Route::get('/edit-scheme-subcategory','Admin\SchemeController@editSchemeSubCategory')->name('edit-scheme-subcategory');
Route::post('/update-scheme-subcategory','Admin\SchemeController@updateSchemeSubCategory')->name('update-scheme-subcategory');
Route::post('/delete-scheme-subcategory','Admin\SchemeController@deleteSchemeSubCategory')->name('delete-scheme-subcategory');
Route::get('/add-scheme-subcategory','Admin\SchemeController@addSchemeSubCategory')->name('add-scheme-subcategory');
Route::post('/add-scheme-subcategory','Admin\SchemeController@createSchemeSubCategory')->name('add-scheme-subcategory');

// manage scheme component
Route::get('/manage-scheme-component','Admin\SchemeController@manageSchemeComponent')->name('manage-scheme-component');
Route::get('/edit-scheme-component','Admin\SchemeController@editSchemeComponent')->name('edit-scheme-component');
Route::post('/update-scheme-component','Admin\SchemeController@updateSchemeComponent')->name('update-scheme-component');
Route::post('/delete-scheme-component','Admin\SchemeController@deleteSchemeComponent')->name('delete-scheme-component');
Route::get('/add-scheme-component','Admin\SchemeController@addSchemeComponent')->name('add-scheme-component');
Route::post('/add-scheme-component','Admin\SchemeController@createSchemeComponent')->name('add-scheme-component');

// manage scheme sub component
Route::get('/manage-scheme-subcomponent','Admin\SchemeController@manageSchemeSubComponent')->name('manage-scheme-subcomponent');
Route::get('/edit-scheme-subcomponent','Admin\SchemeController@editSchemeSubComponent')->name('edit-scheme-subcomponent');
Route::post('/update-scheme-subcomponent','Admin\SchemeController@updateSchemeSubComponent')->name('update-scheme-subcomponent');
Route::post('/delete-scheme-subcomponent','Admin\SchemeController@deleteSchemeSubComponent')->name('delete-scheme-subcomponent');
Route::get('/add-scheme-subcomponent','Admin\SchemeController@addSchemeSubComponent')->name('add-scheme-subcomponent');
Route::post('/add-scheme-subcomponent','Admin\SchemeController@createSchemeSubComponent')->name('add-scheme-subcomponent');


// manage scheme
Route::get('/manage-pscheme-category','Admin\SchemeController@managePSchemeCategory')->name('manage-pscheme-category');
Route::get('/edit-pscheme-category','Admin\SchemeController@editPSchemeCategory')->name('edit-pscheme-category');
Route::post('/update-pscheme-category','Admin\SchemeController@updatePSchemeCategory')->name('update-pscheme-category');
Route::post('/delete-pscheme-category','Admin\SchemeController@deletePSchemeCategory')->name('delete-pscheme-category');
Route::get('/add-pscheme-category','Admin\SchemeController@addPSchemeCategory')->name('add-pscheme-category');
Route::post('/add-pscheme-category','Admin\SchemeController@createPSchemeCategory')->name('add-pscheme-category');

// manage subsidy
Route::get('/manage-subsidy-state','Admin\SubsidyController@manageStateSubsidy')->name('manage-subsidy-state');

// manage scheme
Route::get('/manage-scheme','Admin\SchemeController@manageScheme')->name('manage-scheme');
Route::get('/edit-scheme','Admin\SchemeController@editScheme')->name('edit-scheme');
Route::post('/update-scheme','Admin\SchemeController@updateScheme')->name('update-scheme');
Route::post('/delete-scheme','Admin\SchemeController@deleteScheme')->name('delete-scheme');
Route::get('/add-scheme','Admin\SchemeController@addScheme')->name('add-scheme');
Route::post('/add-scheme','Admin\SchemeController@createScheme')->name('add-scheme');
Route::get('/fetch-scheme-category', 'Admin\SchemeController@fetchSchemeCategory')->name('fetch-scheme-category');
Route::get('/fetch-component-type', 'Admin\SchemeController@fetchComponentType')->name('fetch-component-type');
Route::get('/fetch-components', 'Admin\SchemeController@fetchComponent')->name('fetch-components');
Route::get('/fetch-sub-components', 'Admin\SchemeController@fetchSubComponent')->name('fetch-sub-components');

//manage farmer

Route::get('/manage-farmer','Admin\FarmerController@manageFarmers')->name('manage-farmer');
Route::get('/add-farmer','Admin\FarmerController@addFarmer')->name('add-farmer');
Route::post('/add-farmer','Admin\FarmerController@createFarmer')->name('add-farmer');
Route::get('/edit-farmer','Admin\FarmerController@editFarmer')->name('edit-farmer');
Route::post('/update-farmer','Admin\FarmerController@updateFarmer')->name('update-farmer');
Route::post('/delete-farmer','Admin\FarmerController@deleteFarmer')->name('delete-farmer');

//setting admin
Route::get('/admin-profile','Admin\AdminController@viewAdminProfile')->name('admin-profile');
Route::post('/admin-profile','Admin\AdminController@updateAdminProfile')->name('admin-profile');
Route::post('/change-password', 'Admin\AdminController@changePassword')->name('change-password');

// cron
Route::get('/market', 'CronController@marketPrice');
Route::get('/latest', 'CronController@latestVideos');


// ajax
Route::get('/ajax-tehsil', 'AjaxController@fetchTehsil');
Route::get('/ajax-village', 'AjaxController@fetchVillage');

