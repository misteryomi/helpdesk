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

Route::get('/', 'TicketsController@index')->name('index');
Route::get('tickets', 'TicketsController@index')->name('tickets.list');
Route::get('ticket/new', 'TicketsController@create')->name('tickets.new');
Route::get('ticket/{id}', 'TicketsController@show')->name('tickets.show');


Route::prefix('api/v1')->group(function() {
    Route::get('departments', 'DepartmentsController')->name('departments.list');
   
    // Route::prefix('tickets')->name('tickets')->group(function() {
        Route::get('tickets/{count?}', 'TicketsController@list')->name('list');
        Route::post('ticket/new', 'TicketsController@store');
    // });
});