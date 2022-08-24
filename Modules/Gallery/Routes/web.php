<?php

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'isInstalledCheck']
    ],
    function () {
        Route::prefix('gallery')->group(function () {
            Route::group(['middleware' => ['loginCheck']], function () {

                Route::get('/', 'GalleryController@imageGallery')->name('image-gallery');
                Route::post('image-upload', 'GalleryController@imageUpload')->name('image-upload');
                Route::get('delete-image', 'AlbumController@deleteImage')->name('delete-image');

                Route::post('video-upload', 'GalleryController@videoUpload')->name('video-upload');
                Route::delete('delete-video', 'GalleryController@deleteVideo')->name('delete-video');

                Route::post('audio-upload', 'GalleryController@audioUpload')->name('audio-upload');
                Route::delete('delete-audio', 'GalleryController@deleteAudio')->name('delete-audio');

                Route::get('fetch-image', 'GalleryController@fetchImage')->name('fetch-image');
                Route::get('fetch-video', 'GalleryController@fetchVideo')->name('fetch-video');
                Route::get('fetch-audio', 'GalleryController@fetchAudio')->name('fetch-audio');

                //album-routes
                Route::get('image-albums', 'AlbumController@albums')->name('albums')->middleware('permissionCheck:album_read');
                Route::post('add-album', 'AlbumController@addAlbum')->name('add-album')->middleware('permissionCheck:album_write');
                Route::get('edit-album/{id}', 'AlbumController@editAlbum')->name('edit-album')->middleware('permissionCheck:album_write');
                Route::post('update-album', 'AlbumController@updateAlbum')->name('update-album')->middleware('permissionCheck:album_write');

                //Route::get('album-categories', 'AlbumController@categories')->name('album-categories')->middleware('permissionCheck:album_read');
                //Route::post('add-album-category', 'AlbumController@addCategory')->name('add-album-category')->middleware('permissionCheck:album_write');
                //Route::get('edit-album-category/{id}', 'AlbumController@editCategory')->name('edit-album-category')->middleware('permissionCheck:album_write');
                //Route::post('update-album-category', 'AlbumController@updateCategory')->name('update-album-category')->middleware('permissionCheck:album_write');

                Route::get('images', 'AlbumController@index')->name('images')->middleware('permissionCheck:album_read');
                Route::get('add-gallery-image', 'AlbumController@addImage')->name('add-gallery-image')->middleware('permissionCheck:album_write');
                Route::post('add-album-image', 'AlbumController@saveImageGallery')->name('add-album-image')->middleware('permissionCheck:album_write');
                Route::get('edit-gallery-image/{id}', 'AlbumController@editImage')->name('edit-gallery-image')->middleware('permissionCheck:album_write');
                Route::post('update-album-image', 'AlbumController@updateImage')->name('update-album-image')->middleware('permissionCheck:album_write');

                Route::post('/album/fetch', 'AlbumController@fetchAlbum')->name('album-fetch')->middleware('permissionCheck:album_read');
                Route::post('/album/tabs/fetch', 'AlbumController@fetchTabs')->name('album-tabs-fetch')->middleware('permissionCheck:album_read');

                Route::post('set-cover', 'AlbumController@setCover')->name('set-cover')->middleware('permissionCheck:album_write');

                Route::get('/filter', 'AlbumController@filterImage')->name('filter-image')->middleware('permissionCheck:album_read');
                
                // files gallery added by majid molaea
                Route::get('/files', 'FileController@index')->name('files');
                Route::post('/files', 'FileController@store')->name('files.store');
                Route::get('/files/delete/{id}', 'FileController@delete');
            });
        });
    }

);

Route::get('delete_image', 'GalleryController@delete_image');
Route::get('fetch-video-selected/{id}', 'GalleryController@fetch_video_selected');
Route::get('fetch-audio-selected/{id}', 'GalleryController@fetch_audio_selected');
Route::get('fetch-editor-image/{id}', 'GalleryController@fetchEditorImage');
