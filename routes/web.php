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
    Route::get('/agents/{id}','App\Http\Controllers\AgentsController@view');
    Route::get('/agents/assign-atircle/{agent_id}/{article_id}','App\Http\Controllers\AgentSController@assignArticle');
    Route::get('/agents/view-article/{article_id}','App\Http\Controllers\AgentSController@viewTransferedArticle');
    Route::post('/agents/update-offer/{id}','App\Http\Controllers\AgentSController@updateOffer');
    Route::post('/agents/send-message/{id}','App\Http\Controllers\AgentSController@sendMessage');
    Route::get('/agents','App\Http\Controllers\AgentsController@index');

    
    
});
