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

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => 'parser'
    ],
    function () {
        Route::get('', 'ParserController@index')->name('parser.index');
        Route::get('test', 'ParserController@test')->name('parser.test');
        Route::post('/parse','ParserController@parse')->name('parser.parse');
        Route::post('/union','ParserController@union')->name('parser.union');
        Route::get('/parsed/{type}', 'ParserController@parsed')->name('parser.parsed');
        Route::get('/download/{type}/{filename}', 'ParserController@download')->name('parser.download');
    }
);

Auth::routes();
