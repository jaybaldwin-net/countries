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

Route::get('/', 'CountryController@index');


Route::post('/search/name', 'CountryController@nameSearch');
Route::post('/search/full', 'CountryController@fullSearch');

Route::get('/codes/get', 'CountryController@getCodes');
Route::get('/currencies/get', 'CountryController@getCurrencies');
Route::post('/currency/create', 'CountryController@createCurrencies');
Route::get('/languages/get', 'CountryController@getLanguages');
Route::get('/dialling-codes/get', 'CountryController@getDiallingCodes');
Route::get('/regions/get', 'CountryController@getRegions');

Route::post('/country/create', 'CountryController@createCountry');
Route::post('/country/edit', 'CountryController@editCountry');
Route::post('/country/submit_edit', 'CountryController@performEditCountry');
