<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/journal')->group(function () {
    Route::post('/', 'JournalController@get');
    Route::post('/columns', 'JournalController@sendColumns');
    Route::post('/update', 'JournalController@update');
});
