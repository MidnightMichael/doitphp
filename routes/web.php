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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/debug-lists', 'API\TaskListController@index');

Route::middleware(['auth'])->group(function() {
    Route::get('/lists', 'API\TaskListController@index');
    Route::post('/lists/add', 'API\TaskListController@store');
    Route::post('/lists/add/task', 'API\TaskController@store');

    Route::post('/tasks/update', 'API\TaskController@update');
    Route::post('/tasks/copy', 'API\TaskController@copyTask');
    Route::post('/tasks/move', 'API\TaskController@moveTask');
});
