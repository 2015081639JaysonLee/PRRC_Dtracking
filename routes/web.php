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
Route::post('/jsonFile', 'PagesController@getJsonFile');
Route::get('/accepted', 'PagesController@accepted');
// Route::get('/inactive', 'PagesController@inactive');
Route::get('/inactive', function(){
    abort(404);
});
Route::get('/receive', 'PagesController@receive');
Route::get('/soft', 'PagesController@soft');

Route::post('/restore', 'DocuController@restore');
Route::post('/approve', 'DocuController@approve');
Route::get('/audit/{id}', 'DocuController@audit');
Route::post('/sendTo', 'DocuController@sendTo');
Route::post('/routeInfo', 'DocuController@routeInfo');
Route::post('/editRouteInfo', 'DocuController@editRouteInfo');
Route::resource('docu', 'DocuController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dynamic_pdf', 'DynamicPDFController@index');

Route::get('/dynamic_pdf/pdf/{id}', 'DynamicPDFController@pdf');

Route::get('/users', function(){
    abort(404);
});