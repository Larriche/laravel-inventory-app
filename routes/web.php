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


Auth::routes();

// Resource route for managing item types
Route::resource('item_types', 'TypesController');

// Resource route for managing vendors
Route::resource('item_vendors', 'VendorsController');

// Resource route for managing items
Route::resource('items', 'ItemsController');

// Home route
Route::get('/', 'DashboardController@index');
