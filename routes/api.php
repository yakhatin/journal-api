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

Route::prefix('/subjects')->group(function () {
    Route::post('/', 'SubjectController@get');
    Route::post('/delete', 'SubjectController@delete');
    Route::post('/update', 'SubjectController@update');
    Route::post('/insert', 'SubjectController@insert');
});

Route::prefix('/subject_types')->group(function () {
    Route::post('/', 'SubjectTypeController@get');
    Route::post('/delete', 'SubjectTypeController@delete');
    Route::post('/update', 'SubjectTypeController@update');
    Route::post('/insert', 'SubjectTypeController@insert');
});

Route::prefix('/exercises')->group(function () {
    Route::post('/', 'ExerciseController@get');
    Route::post('/delete', 'ExerciseController@delete');
    Route::post('/update', 'ExerciseController@update');
    Route::post('/insert', 'ExerciseController@insert');
});

Route::prefix('/score_types')->group(function () {
    Route::post('/', 'ScoreTypeController@get');
    Route::post('/delete', 'ScoreTypeController@delete');
    Route::post('/update', 'ScoreTypeController@update');
    Route::post('/insert', 'ScoreTypeController@insert');
});
