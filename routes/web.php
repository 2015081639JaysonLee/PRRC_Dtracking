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

Route::resource('docu', 'DocuController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/live_search', 'LiveSearch@index');
Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
Route::get('/dynamic_pdf', 'DynamicPDFController@index');

Route::get('/dynamic_pdf/pdf/{id}', 'DynamicPDFController@pdf');

