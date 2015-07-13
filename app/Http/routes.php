<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => 'v1'], function()
{

	Route::get('/tickets', 'TicketController@index');

	Route::get('/tickets/{id}', 'TicketController@getIndividual');

	Route::post('/tickets', 'TicketController@create');

	Route::delete('/tickets/{id}', 'TicketController@delete');

	Route::get('/statistic', 'TicketController@getStatistic');
	
});

Route::get('/', function()
{
	var_dump( Zendesk::tickets(63699)->find()->ticket->status);
});
