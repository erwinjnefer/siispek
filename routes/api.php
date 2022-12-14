<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user/detail', 'API\UserController@details');
    Route::post('logout', 'API\UserController@logout');
    Route::post('update-account','API\UserController@updateAccount');

    Route::get('load-chart','API\WorkOrderController@loadChart');
    Route::get('logs-history','API\WorkOrderController@logsHistory');
    Route::get('work-order','API\WorkOrderController@view');
    Route::post('work-order/create','API\WorkOrderController@create');

    Route::get('work-permit','API\WorkPermitController@view');
    Route::get('work-permit/detail','API\WorkPermitController@detail');
    Route::get('work-permit/submit','API\WorkPermitController@submitWp');
    Route::get('work-permit/approve','API\WorkPermitController@approve');
    Route::post('work-permit/reject','API\WorkPermitController@reject');

    Route::post('jsa/review', 'API\WorkPermitController@reviewJsa');


    Route::get('inspeksi','API\InspeksiController@view');
    Route::get('inspeksi/detail','API\InspeksiController@detail');
    Route::post('inspeksi/review-inspeksi-mandiri', 'API\InspeksiController@reviewInspeksiMandiri');
    Route::post('inspeksi/lanjut/create', 'API\InspeksiController@inputInspeksiLanjut');
    Route::post('inspeksi/lanjut/edit', 'API\InspeksiController@editInspeksiLanjut');
    Route::post('inspeksi/upload-foto', 'API\InspeksiController@uploadFoto');
    
    Route::post('inspeksi/approve', 'API\InspeksiController@approve');
    Route::get('inspeksi/open-swa', 'API\InspeksiController@openSwa');
    


    Route::get('sosialisasi','API\SosialisasiController@view');
    Route::get('sosialisasi/detail','API\SosialisasiController@detail');
    Route::post('sosialisasi/create','API\SosialisasiController@create');
    Route::post('sosialisasi/upload-foto', 'API\SosialisasiController@uploadFoto');

});

Route::group(['prefix' => 'rest'], function(){
    Route::get('auth','Rest\InspeksiController@auth');

    Route::get('logs-history','Rest\InspeksiController@logsHistory');
    Route::get('inspeksi','Rest\InspeksiController@view');
    Route::get('inspeksi/detail','Rest\InspeksiController@detail');

    Route::get('inspeksi/read-jsa', 'Rest\InspeksiController@readJsa');
    Route::get('inspeksi/read-sop', 'Rest\InspeksiController@readSop');

    Route::get('inspeksi/inspeksi-mandiri', 'Rest\InspeksiController@inspeksiMandiri');
    Route::get('inspeksi/review-inspeksi-mandiri', 'Rest\InspeksiController@reviewInspeksiMandiri');
    Route::get('inspeksi/submit', 'Rest\InspeksiController@submitInspeksi');

    Route::post('inspeksi/req-open-swa', 'Rest\InspeksiController@reqOpenSwa');

    Route::get('inspeksi/approve', 'Rest\InspeksiController@approve');

    Route::get('inspeksi/lanjut/create', 'Rest\InspeksiController@inputInspeksiLanjut');
    Route::get('inspeksi/lanjut/edit', 'Rest\InspeksiController@editInspeksiLanjut');

    Route::post('inspeksi/upload-foto', 'Rest\InspeksiController@uploadFoto');
    

});

