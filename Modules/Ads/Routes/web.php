<?php

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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'isInstalledCheck']
    ],
    function () {
        Route::prefix('ads')->group(function() {
            Route::group(['middleware'=>['loginCheck', 'XSS']],function(){

                Route::get('/', 'AdsController@index')->name('ads')->middleware('permissionCheck:ads_read');
                Route::get('/create', 'AdsController@create')->name('create-ad')->middleware('permissionCheck:ads_write');
                Route::post('/store', 'AdsController@store')->name('store-ad')->middleware('permissionCheck:ads_write');

                Route::get('/edit/{id}', 'AdsController@edit')->name('edit-ad')->middleware('permissionCheck:ads_write');
                Route::post('/update/{id}', 'AdsController@update')->name('update-ad')->middleware('permissionCheck:ads_write');

                Route::get('/assign', 'AdsController@assignAds')->name('assign-ads')->middleware('permissionCheck:ads_write');

                Route::put('/update/location', 'AdsController@updateLocation')->name('location-update')->middleware('permissionCheck:ads_write');
            
                // add by majid molaei for side ads
                Route::get('/side', 'AdsController@index_side')->name('side')->middleware('permissionCheck:ads_read');
                Route::get('/side/create', 'AdsController@create_side')->name('side.create-ad')->middleware('permissionCheck:ads_write');
                Route::post('/side/store', 'AdsController@store_side')->name('side.store-ad')->middleware('permissionCheck:ads_write');
                Route::get('/side/edit/{id}', 'AdsController@edit_side')->name('side.edit-ad')->middleware('permissionCheck:ads_write');
                Route::post('/side/update/{id}', 'AdsController@update_side')->name('side.update-ad')->middleware('permissionCheck:ads_write');

                // add by majid molaei for center ads
                Route::get('/center', 'AdsController@index_center')->name('center')->middleware('permissionCheck:ads_read');
                Route::get('/center/create', 'AdsController@create_center')->name('center.create-ad')->middleware('permissionCheck:ads_write');
                Route::post('/center/store', 'AdsController@store_center')->name('center.store-ad')->middleware('permissionCheck:ads_write');
                Route::get('/center/edit/{id}', 'AdsController@edit_center')->name('center.edit-ad')->middleware('permissionCheck:ads_write');
                Route::post('/center/update/{id}', 'AdsController@update_center')->name('center.update-ad')->middleware('permissionCheck:ads_write');
            
            });
        });
    });
