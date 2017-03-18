<?php

Route::group(['middleware' => 'web'], function () {

    Route::get(
        'signup',
        'InstalledAppController@index'
    )->name('shopify.signup');

    Route::match(['get', 'post'],
        'install',
        'InstalledAppController@create'
    )->name('shopify.install');

    Route::get(
        'register',
        'RegisteredUsersController@create'
    )->name('shopify.register');

    Route::get(
        'embedded/plans',
        'RecurringChargesController@index'
    )->name('shopify.plans');

    Route::match(['get', 'post'],
        'embedded/plans/create',
        'RecurringChargesController@create'
    )->name('shopify.plan.create');

    Route::get(
        'activate',
        'RecurringChargesController@update'
    )->name('shopify.activate');

    Route::get(
        'embedded/login',
        'AuthorizedUsersController@create'
    )->name('shopify.login');

    Route::get(
        'embedded/dashboard',
        'DashboardController@index'
    )->name('shopify.dashboard');

    Route::get(
        'app/expired',
        'ExpiredSessionsController@index'
    )->name('shopify.expired');

});

Route::group(['prefix' => 'webhooks'], function () {

    Route::post(
        'app/uninstalled',
        'WebhooksController@uninstall'
    )->name('shopify.uninstall');

});
