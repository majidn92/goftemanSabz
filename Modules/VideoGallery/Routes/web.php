<?php

Route::group(

    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'isInstalledCheck']
    ],
    function () {
        Route::prefix('video')->group(function () {
            Route::group(['middleware' => ['loginCheck']], function () {

                // بابت فایل منیجر ایجکس 
                Route::get('/', 'VideoGalleryController@imageGallery')->name('image-gallery');
                Route::post('image-upload', 'VideoGalleryController@imageUpload')->name('image-upload');
                Route::delete('delete-image', 'VideoGalleryController@deleteImage')->name('delete-image');

                Route::post('video-upload', 'VideoGalleryController@videoUpload')->name('video-upload');
                Route::delete('delete-video', 'VideoGalleryController@deleteVideo')->name('delete-video');

                Route::post('audio-upload', 'VideoGalleryController@audioUpload')->name('audio-upload');
                Route::delete('delete-audio', 'VideoGalleryController@deleteAudio')->name('delete-audio');

                Route::get('fetch-image', 'VideoGalleryController@fetchImage')->name('fetch-image');
                Route::get('fetch-video', 'VideoGalleryController@fetchVideo')->name('fetch-video');
                Route::get('fetch-audio', 'VideoGalleryController@fetchAudio')->name('fetch-audio');


                //category-routes
                Route::get('categories', 'CategoryController@categories')->name('video.categories')->middleware('permissionCheck:album_read');
                Route::post('store-category', 'CategoryController@storeCategory')->name('video.store.category')->middleware('permissionCheck:album_write');
                Route::get('edit-category/{id}', 'CategoryController@editCategory')->name('video.edit.category')->middleware('permissionCheck:album_write');
                Route::post('update-category', 'CategoryController@updateCategory')->name('video.update.category')->middleware('permissionCheck:album_write');
                Route::post('delete-category', 'CategoryController@deleteCategory')->name('video.delete.category')->middleware('permissionCheck:album_write');

                //video-routes
                Route::get('videos', 'VideoController@videos')->name('video.videos')->middleware('permissionCheck:album_read');
                Route::get('create-video', 'VideoController@createVideo')->name('video.create.video')->middleware('permissionCheck:album_write');
                Route::post('store-video', 'VideoController@storeVideo')->name('video.store.video')->middleware('permissionCheck:album_write');
                Route::get('edit-video/{id}', 'VideoController@editVideo')->name('video.edit.video')->middleware('permissionCheck:album_write');
                Route::post('update-video', 'VideoController@updateVideo')->name('video.update.video')->middleware('permissionCheck:album_write');
                Route::post('delete-video', 'VideoController@deleteVideo')->name('video.delete.video')->middleware('permissionCheck:album_write');
                Route::get('filter-video', 'VideoController@filterVideo')->name('video.filter.video')->middleware('permissionCheck:album_read');
 


                Route::post('fetch', 'VideoController@fetchVideo')->name('video.fetch')->middleware('permissionCheck:album_read');
                Route::post('/album/tabs/fetch', 'AlbumController@fetchTabs')->name('album-tabs-fetch')->middleware('permissionCheck:album_read');
                Route::post('set-cover', 'AlbumController@setCover')->name('set-cover')->middleware('permissionCheck:album_write');
            });
        });
    }
);
