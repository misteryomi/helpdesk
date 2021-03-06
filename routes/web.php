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
Route::get('/admin/tickets', 'Admin\TicketsController@list')->name('admin.tickets.list');
Route::get('/admin/tickets/{ticket}', 'Admin\TicketsController@show')->name('admin.tickets.show');
Route::post('/admin/{ticket}/reassign', 'Admin\TicketsController@reassign')->name('admin.tickets.reassign');
Route::get('/admin/export', 'Admin\TicketsController@export')->name('admin.tickets.export');


Route::get('/', 'TicketsController@index')->name('tickets.summary');
Route::get('tickets', 'TicketsController@list')->name('tickets.list');
Route::get('ticket/new', 'TicketsController@create')->name('tickets.new');
Route::get('ticket/{ticket}', 'TicketsController@show')->name('tickets.show');
Route::get('ticket/{ticket}/approve', 'TicketsController@approveTicket')->name('tickets.approve');


Route::prefix('api/v1')->name('api.')->group(function() {
    Route::get('departments', 'DepartmentsController')->name('departments.list');   
    Route::get('users', 'UsersController')->name('users.list');   

    Route::prefix('tickets')->name('tickets.')->group(function() {
        Route::get('tickets/{count?}', 'TicketsController@apiList')->name('list');
        Route::post('ticket/new', 'TicketsController@store')->name('new');
        Route::post('ticket/{ticket}/conversation/new', 'TicketConversationsController@store')->name('conversation.new');
    });
    
});