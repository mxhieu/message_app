<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/chart', 'ChartController@chart');

Route::get('/message/total', 'MessageController@getTotalMessage');

Route::get('/message/user-activity', 'MessageController@getUsersActive');

Route::get('/message/user-inactivity', 'MessageController@getUsersInactive');
