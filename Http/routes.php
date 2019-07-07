<?php

Route::group(['middleware' => ['web', 'permission:admin_access'], 'prefix' => getAdminPrefix('users')], function () {
    Route::group(['middleware' => ['permission:modules_users_admin_list']], function () {
        Route::any('/', 'Modules\Users\Http\Controllers\AdminController@index')->name('admin.users');
    });

    Route::group(['middleware' => ['permission:modules_users_admin_delete']], function () {
        Route::post('/delete/all', 'Modules\Users\Http\Controllers\AdminController@deleteAll')->name('admin.users.delete.all');
        Route::get('/delete/{user}', 'Modules\Users\Http\Controllers\AdminController@delete')->name('admin.users.delete');
    });

    Route::group(['middleware' => ['permission:modules_users_admin_create']], function () {
        Route::get('/create', 'Modules\Users\Http\Controllers\AdminController@form')->name('admin.users.create');
    });

    Route::group(['middleware' => ['permission:modules_users_admin_edit']], function () {
        Route::get('/edit/{user}', 'Modules\Users\Http\Controllers\AdminController@form')->name('admin.users.edit');
    });

    Route::post('/save/{user?}', 'Modules\Users\Http\Controllers\AdminController@save')->name('admin.users.save');
});
