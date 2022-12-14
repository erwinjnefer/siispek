<?php

use App\InspeksiLanjut;
use App\Providers\Whatsapp;
use Illuminate\Support\Facades\Auth;
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
    return redirect('login');
});

Route::get('/test', function () {
    $ins_lanjut = InspeksiLanjut::all();
    
    return 'done';
});

Route::get('/wa', function () {
    event(new Whatsapp('6282359250040', '😁 Halo Terimakasih 🙏'));
    // $res = $wa->send('6287865525533','😁 Halo Terimakasih 🙏');
    // return json_decode($res, true);
});

Route::get('test-map','TestCotnroller@test');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//admin_template
Route::get('/dashboard', 'HomeController@dashboard');

Route::get('work-order','WorkOrderController@view');
Route::post('work-order/create','WorkOrderController@create');
Route::get('work-order/delete','WorkOrderController@delete');
Route::post('work-order/edit-unit','WorkOrderController@editUnit');

Route::get('logs-history','WorkOrderController@logsHistory');

Route::get('generate','WorkPermitController@gen');

Route::get('work-permit','WorkPermitController@view');
Route::get('work-permit/form','WorkPermitController@form');
Route::get('work-permit/form-edit','WorkPermitController@formEdit');
Route::get('work-permit/delete','WorkPermitController@delete');
Route::get('work-permit/detail','WorkPermitController@detail');
Route::get('work-permit/submit','WorkPermitController@submitWp');
Route::get('work-permit/resubmit','WorkPermitController@reSubmitWp');
Route::get('work-permit/print','WorkPermitController@print');
Route::get('work-permit/send-wa','WorkPermitController@sendWa');
Route::post('work-permit/create','WorkPermitController@create');
Route::post('work-permit/update','WorkPermitController@update');
Route::post('work-permit/approve','WorkPermitController@approve');
Route::post('work-permit/reject','WorkPermitController@reject');
Route::post('work-permit/update-bidang','WorkPermitController@updateBidang');

Route::post('work-permit/hirarc-select','WorkPermitController@hirarcSelect');
Route::post('work-permit/pk-select','WorkPermitController@pkSelect');
Route::get('work-permit/manuver-select','WorkPermitController@manuverSelect');
Route::get('work-permit/repair','WorkPermitController@repair');


//JSA
Route::get('/jsa', 'JsaController@index');
Route::get('/jsa/form', 'JsaController@form');
Route::get('/jsa/preview', 'JsaController@preview');
Route::post('jsa/create', 'JsaController@create');
Route::post('jsa/import-analisis', 'JsaController@importAnalisis');
Route::get('jsa/delete', 'JsaController@delete');
Route::get('jsa/reset', 'JsaController@resetJSA');
Route::post('jsa/review', 'JsaController@review');

Route::get('/inspeksi', 'InspeksiController@view');
Route::get('/inspeksi/detail', 'InspeksiController@detail');
Route::get('/inspeksi/form', 'InspeksiController@form');
Route::get('/inspeksi/preview', 'InspeksiController@preview');
Route::post('inspeksi/review-inspeksi-mandiri', 'InspeksiController@reviewInspeksiMandiri');
Route::post('inspeksi/lanjut/create', 'InspeksiController@inputInspeksiLanjut');
Route::post('inspeksi/lanjut/edit', 'InspeksiController@editInspeksiLanjut');

Route::get('inspeksi/delete', 'InspeksiController@delete');
Route::post('inspeksi/approve', 'InspeksiController@approve');
Route::post('inspeksi/upload-foto', 'InspeksiController@uploadFoto');
Route::get('inspeksi/delete-foto', 'InspeksiController@deleteFoto');
Route::post('inspeksi/upload-video', 'InspeksiController@uploadVideo');
Route::get('inspeksi/delete-video', 'InspeksiController@deleteVideo');
Route::get('inspeksi/export', 'InspeksiController@exportPdf');
Route::get('inspeksi/submit', 'InspeksiController@submitInspeksi');
Route::get('inspeksi/open-swa', 'InspeksiController@openSwa');

Route::get('pembagian-tugas-apd/form','PembagianTugasApdController@form');
Route::post('pembagian-tugas-apd/save','PembagianTugasApdController@save');

Route::get('/hirarc', 'HirarcController@index');
Route::get('hirarc/get-by-jp', 'HirarcController@getByJp');
Route::get('hirarc/get-by-id', 'HirarcController@getById');
Route::post('hirarc/create', 'HirarcController@create');
Route::post('hirarc/update', 'HirarcController@update');
Route::get('hirarc/delete', 'HirarcController@delete');

Route::get('sertifikat', 'SertifikatController@index');
Route::get('sertifikat/get-by-jp', 'SertifikatController@getByJp');
Route::get('sertifikat/get-by-id', 'SertifikatController@getById');
Route::post('sertifikat/create', 'SertifikatController@create');
Route::post('sertifikat/update', 'SertifikatController@update');
Route::get('sertifikat/delete', 'SertifikatController@delete');

Route::get('prosedur-kerja', 'ProsedurKerjaController@index');
Route::get('prosedur-kerja/get-by-jp', 'ProsedurKerjaController@getByJp');
Route::get('prosedur-kerja/get-by-id', 'ProsedurKerjaController@getById');
Route::post('prosedur-kerja/create', 'ProsedurKerjaController@create');
Route::post('prosedur-kerja/update', 'ProsedurKerjaController@update');
Route::get('prosedur-kerja/delete', 'ProsedurKerjaController@delete');

Route::get('/unit-pelaksana', 'UnitPelaksanaController@index');
Route::get('unit-pelaksana/load', 'UnitPelaksanaController@load');
Route::post('unit-pelaksana/create', 'UnitPelaksanaController@create');
Route::post('unit-pelaksana/update', 'UnitPelaksanaController@update');
Route::get('unit-pelaksana/delete', 'UnitPelaksanaController@delete');

Route::get('/unit', 'UnitController@index');
Route::get('unit/load', 'UnitController@load');
Route::post('unit/create', 'UnitController@create');
Route::post('unit/update', 'UnitController@update');
Route::get('unit/delete', 'UnitController@delete');

Route::get('pegawai-vendor', 'PegawaiVendorController@index');
Route::get('pegawai-vendor/load', 'PegawaiVendorController@load');
Route::post('pegawai-vendor/create', 'PegawaiVendorController@create');
Route::post('pegawai-vendor/update', 'PegawaiVendorController@update');
Route::get('pegawai-vendor/delete', 'PegawaiVendorController@delete');

Route::get('sosialisasi','SosialisasiController@view');
Route::get('sosialisasi/detail','SosialisasiController@detail');
Route::post('sosialisasi/create','SosialisasiController@create');
Route::get('sosialisasi/delete','SosialisasiController@delete');
Route::post('sosialisasi/upload-foto', 'SosialisasiController@uploadFoto');
Route::post('sosialisasi/upload-video', 'SosialisasiController@uploadVideo');
Route::get('sosialisasi/submit', 'SosialisasiController@submitSos');
Route::get('sosialisasi/delete-foto', 'SosialisasiController@deleteFoto');
Route::get('sosialisasi/map', 'SosialisasiController@map');
Route::get('sosialisasi/map-gardu', 'SosialisasiController@gardu');
Route::get('sosialisasi/sos-map', 'SosialisasiController@sosMap');


Route::get('video', 'VideoController@index');
Route::post('video/create', 'VideoController@create');
Route::post('video/update', 'VideoController@update');
Route::get('video/delete', 'VideoController@delete');





Route::get('/users', 'UserController@index');
Route::post('users/create', 'UserController@create');
Route::post('users/input-no-wa', 'UserController@inputNoWa');
Route::post('users/update', 'UserController@update');
Route::post('users/validasi', 'UserController@validasi');
Route::post('users/update-level-bidang', 'UserController@updateLevelBidang');
Route::get('users/delete', 'UserController@delete');

Route::post('users/unit/create', 'UserController@unitCreate');
Route::post('users/unit/update', 'UserController@unitUpdate');


Route::post('login-pegawai', 'AuthPegawaiController@login');
Route::get('logout-pegawai', 'AuthPegawaiController@logout');
Route::get('finspeksi', 'FPageController@index');
Route::get('finspeksi/detail', 'FPageController@detail');
Route::post('finspeksi/inspeksi-mandiri', 'FPageController@inspeksiMandiri');
Route::post('finspeksi/lanjut/create', 'FPageController@inputInspeksiLanjut');
Route::post('finspeksi/lanjut/edit', 'FPageController@editInspeksiLanjut');

Route::post('finspeksi/approve', 'FPageController@approve');
Route::post('finspeksi/upload-foto', 'FPageController@uploadFoto');
Route::post('finspeksi/req-open-swa', 'FPageController@reqOpenSwa');
Route::post('finspeksi/review-inspeksi-mandiri', 'FPageController@reviewInspeksiMandiri');
Route::get('finspeksi/delete-foto', 'FPageController@deleteFoto');
Route::post('finspeksi/upload-video', 'FPageController@uploadVideo');
Route::get('finspeksi/delete-video', 'FPageController@deleteVideo');
Route::get('finspeksi/submit', 'FPageController@submitInspeksi');
Route::get('finspeksi/export', 'FPageController@exportPdf');
Route::get('finspeksi/preview-jsa', 'FPageController@previewJsa');






