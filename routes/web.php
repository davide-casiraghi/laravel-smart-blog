<?php

    Route::group(['namespace' => 'DavideCasiraghi\LaravelSmartBlog\Http\Controllers', 'middleware' => 'web'], function () {

        /* Post Categories */
        Route::resource('categories', 'CategoryController');

        /* Category Translations */
        Route::get('/categoryTranslations/{categoryId}/{languageCode}/create', 'CategoryTranslationController@create');
        Route::get('/categoryTranslations/{categoryId}/{languageCode}/edit', 'CategoryTranslationController@edit');
        Route::post('/categoryTranslations/store', 'CategoryTranslationController@store')->name('categoryTranslations.store');
        Route::put('/categoryTranslations/update', 'CategoryTranslationController@update')->name('categoryTranslations.update');
        Route::delete('/categoryTranslations/destroy/{categoryTranslationId}', 'CategoryTranslationController@destroy')->name('categoryTranslations.destroy');

        /* Posts */
        Route::resource('posts', 'PostController');
        Route::get('/post/{slug}', 'PostController@postBySlug')->where('postBySlug', '[a-z]+');

        /* Posts Translations */
        Route::get('/postTranslations/{postId}/{languageCode}/create', 'PostTranslationController@create');
        Route::get('/postTranslations/{postId}/{languageCode}/edit', 'PostTranslationController@edit');
        Route::post('/postTranslations/store', 'PostTranslationController@store')->name('postTranslations.store');
        Route::put('/postTranslations/update', 'PostTranslationController@update')->name('postTranslations.update');
        Route::delete('/postTranslations/destroy/{postTranslationId}', 'PostTranslationController@destroy')->name('postTranslations.destroy');

        /* Blog */
        Route::resource('blogs', 'BlogController');

        /* Blogs Translations */
        Route::get('/blogTranslations/{blogId}/{languageCode}/create', 'BlogTranslationController@create');
        Route::get('/blogTranslations/{blogId}/{languageCode}/edit', 'BlogTranslationController@edit');
        Route::post('/blogTranslations/store', 'BlogTranslationController@store')->name('blogTranslations.store');
        Route::put('/blogTranslations/update', 'BlogTranslationController@update')->name('blogTranslations.update');
        Route::delete('/blogTranslations/destroy/{blogTranslationId}', 'BlogTranslationController@destroy')->name('blogTranslations.destroy');

        //Route::get('/blog/{blogKind}/{categoryId}/', 'BlogController@index');
    });
