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

Route::prefix('/groups')->group(function () {
    Route::post('/', 'GroupController@get');
    Route::post('/delete', 'GroupController@delete');
    Route::post('/update', 'GroupController@update');
    Route::post('/insert', 'GroupController@insert');
});

Route::prefix('/students')->group(function () {
    Route::post('/', 'StudentController@get');
    Route::post('/delete', 'StudentController@delete');
    Route::post('/update', 'StudentController@update');
    Route::post('/insert', 'StudentController@insert');
});
