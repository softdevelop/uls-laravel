<?php

Route::group(['prefix' => 'site-configuration'], function() {
    Route::resource('tag-content', 'Rowboat\TagContent\Http\Controllers\TagContentController');

    Route::group(['prefix' => 'api'], function(){

        Route::resource('tag-content', 'Rowboat\TagContent\Http\Controllers\Api\TagContentController');

    });

});

