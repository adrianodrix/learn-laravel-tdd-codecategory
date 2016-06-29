<?php

Route::group(array(
    'prefix' => 'admin/categories',
    'as' => 'admin.categories.',
    'middleware' => array('web'),
    'namespace' => 'CodePress\CodeCategory\Controllers'),
    function() {
        Route::get('/',       array('uses' => 'AdminCategoriesController@index',  'as' => 'index'));
        Route::get('/create', array('uses' => 'AdminCategoriesController@create', 'as' => 'create'));
        Route::post('/store', array('uses' => 'AdminCategoriesController@store',  'as' => 'store'));
        Route::get('/{id}/delete', array('uses' => 'AdminCategoriesController@destroy', 'as' => 'destroy'));
        Route::get('/{id}/edit', array('uses' => 'AdminCategoriesController@edit', 'as' => 'edit'));
    }
);