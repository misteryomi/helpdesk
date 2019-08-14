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
Route::get('/admin', 'Admin\DashboardController@index')->name('admin.dashboard');
Route::get('/admin/tickets', 'Admin\TicketsController@list')->name('admin.tickets');
Route::get('/admin/tickets/{ticket}', 'Admin\TicketsController@show')->name('admin.tickets.show');


Route::get('/', 'TicketsController@index')->name('tickets.summary');
Route::get('tickets', 'TicketsController@list')->name('tickets.list');
Route::get('ticket/new', 'TicketsController@create')->name('tickets.new');
Route::get('ticket/{ticket}', 'TicketsController@show')->name('tickets.show');


// Route::prefix('api/v1')->name('api.')->group(function() {
// });