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


// Authentication routes
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

// Resource route for managing item types
Route::resource('item_types', 'TypesController');

// Resource route for managing vendors
Route::resource('item_vendors', 'VendorsController');

// Resource route for managing items
Route::resource('items', 'ItemsController');

// Home route
Route::get('/home', 'DashboardController@index');
Route::get('/', 'DashboardController@index');

// Routes for getting data about statistics
Route::get('/stats/item_percentages', 'DashboardController@getItemsPercentages');

// Routes for backups and restore functionality
Route::get('/backups', 'BackupsController@index');
Route::post('/backup', 'BackupsController@backup');
Route::post('/restore', 'BackupsController@restore');

// Users Routes
Route::resource('users', 'UsersController');
Route::get('my_account', 'UsersController@show');
Route::get('activate', 'UsersController@activate');
Route::post('activate', 'UsersController@updatePassword');
