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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google-calendar/connect', 'GoogleCalendarController@connect');
Route::post('/google-calendar/connect', 'GoogleCalendarController@store');
Route::get('get-resource', 'GoogleCalendarController@getResources');
