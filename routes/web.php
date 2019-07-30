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

Route::get('/', 'PagesController@Index');

Route::get('/dashboard', 'PagesController@Dashboard');

Route::resource('api/holidayrequests','HolidayRequests');
Route::resource('api/users','Users')->except(['index','edit','show','create']);
Route::resource('api/companyholidays','CompanyHolidays')->except(['index','edit','show','create','update']);
Route::resource('api/sickness','Sickness')->except(['index','edit','show','create','update']);
Route::resource('api/training','Training')->except(['index','edit','show','create','update']);

Auth::routes();

