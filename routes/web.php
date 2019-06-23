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

Route::resource('dashboard','HolidayRequests');

Route::resource('dashboard/users','Users')->except(['index','edit','show','create']);
Route::resource('dashboard/companyholidays','CompanyHolidays')->except(['index','edit','show','create']);

Auth::routes();

