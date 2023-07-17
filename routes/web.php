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


Route::get('/','LoginController@index');
Route::get('/login','LoginController@index');
Route::get('/login/forgot','LoginController@viewForgot');
Route::post('/login/validate',['as' => 'Login.validate','uses'=>'LoginController@login']);
Route::post('/login/sendEmail',['as'=>'Login.sendEmail','uses'=>'LoginController@sendEmail']);
Route::get('/login/create','LoginController@create');
Route::post('/login/store',['as'=>'Login.store','uses'=>'LoginController@store']);
Route::get('/logout','LoginController@logout');

Route::resource('/servicio','ServicioController');
Route::get('/servicio/delete/{id}', ['as' => '/servicio/delete', 'uses'=>'ServicioController@delete']);

Route::resource('/usuario','UsuarioController');
Route::get('/usuario/token/{token}',['as'=>'/usuario/token','uses'=>'UsuarioController@validateToken']);
Route::get('/usuario/index/{token}',['as'=>'/usuario/index','uses'=>'UsuarioController@index']);
Route::get('/usuario/delete/{id}',['as'=>'/usuario/delete','uses'=>'UsuarioController@delete']);
Route::get('/usuario/editUsuario/{usuario}',['as'=>'/usuario/edit','uses'=>'UsuarioController@editUsuario']);
Route::put('/usuario/updateUsuario/{usuario}',['as'=>'/usuario/update','uses'=>'UsuarioController@updateUsuario']);
Route::get('/usuario/editStatus/{id}',['as'=>'/usuario/editStatus','uses'=>'UsuarioController@editStatus']);

Route::resource('/grupo','GrupoController');
Route::get('/grupo/delete/{id}',['as'=>'/grupo/delete','uses'=>'GrupoController@delete']);
Route::get('/historico','HistoricoController@index');

Route::resource('/rol','RolController');
Route::get('/rol/delete/{id}', ['as' => '/rol/delete', 'uses'=>'RolController@delete']);

Route::resource('/sistema','SistemaController');
Route::get('/sistema/delete/{id}', ['as' => '/sistema/delete', 'uses'=>'SistemaController@delete']);

Route::resource('/ubicacion','UbicacionController');
Route::get('/ubicacion/delete/{id}', ['as' => '/ubicacion/delete', 'uses'=>'UbicacionController@delete']);

Route::resource('/categoria','CategoriaController');
Route::get('/categoria/delete/{id}', ['as' => '/categoria/delete', 'uses'=>'CategoriaController@delete']);

Route::resource('/estado','EstadoController');
Route::get('/estado/delete/{id}', ['as' => '/estado/delete', 'uses'=>'EstadoController@delete']);

Route::resource('/dispositivo','DispositivoController');
Route::get('/dispositivo/delete/{id}', ['as' => '/dispositivo/delete', 'uses'=>'DispositivoController@delete']);
Route::post('/dispositivo/servicio/{id}', ['as' => '/dispositivo/servicio', 'uses'=>'DispositivoController@addService']);
Route::get('/dispositivo/servicio/delete/{id}', ['as' => '/dispositivo/servicio/delete', 'uses'=>'DispositivoController@deleteService']);
Route::post('/dispositivo/responsable/{id}', ['as' => '/dispositivo/responsable', 'uses'=>'DispositivoController@addResponsable']);
Route::get('/dispositivo/responsable/delete/{id}', ['as' => '/dispositivo/responsable/delete', 'uses'=>'DispositivoController@deleteResponsable']);

Route::get('/monitoreo','MonitoreoController@index');
Route::get('/monitoreo/{dispositivo}',['as'=>'monitoreo.show','uses'=>'MonitoreoController@show']);
Route::post('/monitoreo/correo/{id_dispositivo}',['as'=>'/monitoreo/correo','uses'=>'MonitoreoController@sendCorreo']);

Route::resource('/tiposervicio','TipoServicioController');
Route::get('/tiposervicio/delete/{id}', ['as' => '/tiposervicio/delete', 'uses'=>'TipoServicioController@delete']);
Route::get('/ping/{id}', 'DispositivoController@ping');
