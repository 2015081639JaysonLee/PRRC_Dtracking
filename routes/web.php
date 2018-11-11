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

Route::get('/', 'PagesController@index');
Route::get('/intransit', 'PagesController@intransit');
Route::get('/archived', 'PagesController@archived');

Route::get('/audit/{id}', 'DocuController@audit');
Route::post('/sendTo', 'DocuController@sendTo');
Route::post('/routeInfo', 'DocuController@routeInfo');
Route::post('/editRouteInfo', 'DocuController@editRouteInfo');
Route::resource('docu', 'DocuController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get-docu-datatable', 'DatatableController@getDocuDatatable');


Route::get('/dynamic_pdf', 'DynamicPDFController@index');

Route::get('/dynamic_pdf/pdf/{id}', 'DynamicPDFController@pdf');


/** 
 * 
 * Route::get('/dynamic_dependent', 'DynamicDependent@index');

*Route::post('dynamic_dependent/fetch', 'DynamicDependent@fetch')->name('dynamicdependent.fetch');
*/

