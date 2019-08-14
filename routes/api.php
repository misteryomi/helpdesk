<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('departments', 'DepartmentsController')->name('departments.list');   

Route::prefix('tickets')->name('tickets')->group(function() {
    Route::get('tickets/{count?}', 'TicketsController@apiList')->name('list');
    Route::post('ticket/new', 'TicketsController@store')->name('ticket.new');
    Route::post('ticket/{ticket}/conversation/new', 'TicketConversationsController@store')->name('ticket.conversation.new');
});

