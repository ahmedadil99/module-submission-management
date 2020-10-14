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
Route::get('/register','App\Http\Controllers\RegisterController@register');
Route::post('/register','App\Http\Controllers\RegisterController@create');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/agents/{id}','App\Http\Controllers\AgentsController@view');
    Route::get('/writers/{id}','App\Http\Controllers\AgentsController@viewWriters');
    Route::get('/agents/assign-atircle/{agent_id}/{article_id}','App\Http\Controllers\AgentsController@assignArticle');
    Route::get('/agents/view-article/{article_id}','App\Http\Controllers\AgentsController@viewTransferedArticle');
    Route::post('/agents/update-offer/{id}','App\Http\Controllers\AgentsController@updateOffer');
    Route::get('/agent/my-articles', 'App\Http\Controllers\AgentsController@agentsArticles');
    Route::post('/agent/offer/{id}','App\Http\Controllers\AgentsController@agentProcessOffer');
    Route::get('/agent/view-article/{id}', 'App\Http\Controllers\AgentsController@agentArticle');
    Route::post('/agents/send-message/{id}','App\Http\Controllers\AgentsController@sendMessage');    
    Route::get('/agents','App\Http\Controllers\AgentsController@index');
    Route::post('/writer/charge/{id}', 'App\Http\Controllers\AgentsController@writerCharge');
    Route::get('/agent/writers-list','App\Http\Controllers\AgentsController@agentWriterList');
});
