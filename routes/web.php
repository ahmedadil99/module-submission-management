<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('admin');
});
//Route::get('/agents','AgentController@index')->name('index');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/agents/assign-article/{id}','App\Http\Controllers\AgentSController@assignArticle');
    Route::resource('/agents', 'App\Http\Controllers\AgentsController');

    
    
});
