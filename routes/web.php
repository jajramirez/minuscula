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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::group(['middleware' => ['administrador']], function () {


	Route::get('/cargafuid', [
		'as' => 'home.carga', 
		'uses' => 'HomeController@carga'
		]);

	Route::get('/listafuid', [
		'as' => 'home.fuid', 
		'uses' => 'HomeController@fuid'
		]);


	Route::post('/store', [
		'as' => 'home.store', 
		'uses' => 'HomeController@store'
		]);

	Route::resource('/usuarios','UsuarioController');
		Route::get('usuarios/{id}/destroy', [
				'uses' => 'UsuarioController@destroy',
				'as' =>  'usuarios.destroy'
			]);

	Route::resource('/seris','SeriController');
		Route::get('seris/{cod_enti}/destroy', [
				'uses' => 'SeriController@destroy',
				'as' =>  'seris.destroy'
			]);
		Route::post('seris/actualizar', [
				'uses' => 'SeriController@actualizar',
				'as' =>  'seris.actualizar'
			]);

		Route::post('seris/buscarccd', [
				'uses' => 'SeriController@buscarccd',
				'as' =>  'seris.buscarccd'
			]);


	Route::resource('/ccd','CcdController');
		Route::get('ccd/{id}/destroy', [
				'uses' => 'CcdController@destroy',
				'as' =>  'ccd.destroy'
			]);
		Route::post('ccd/actualizar', [
				'uses' => 'CcdController@actualizar',
				'as' =>  'ccd.actualizar'
			]);


	Route::resource('/dependencias','DependenciaController');
		Route::get('dependencias/{id}/destroy', [
				'uses' => 'DependenciaController@destroy',
				'as' =>  'dependencias.destroy'
			]);
		Route::post('dependencias/actualizar', [
				'uses' => 'DependenciaController@actualizar',
				'as' =>  'dependencias.actualizar'
			]);


	
		Route::get('trd/{id}/destroy', [
				'uses' => 'TrdController@destroy',
				'as' =>  'trd.destroy'
			]);
		Route::post('trd/actualizar', [
				'uses' => 'TrdController@actualizar',
				'as' =>  'trd.actualizar'
			]);
		Route::post('trd/cargartrd', [
				'uses' => 'TrdController@cargartrd',
				'as' =>  'trd.cargartrd'
			]);
		Route::get('trd/cargararchivo', [
				'uses' => 'TrdController@cargararchivo',
				'as' =>  'trd.cargararchivo'
			]);
		Route::post('trd/buscarfuid', [
				'uses' => 'TrdController@buscarfuid',
				'as' =>  'trd.buscarfuid'
			]);
		Route::post('trd/datostrd', [
				'uses' => 'TrdController@datostrd',
				'as' =>  'trd.datostrd'
			]);
	Route::resource('/trd','TrdController', ['only'=> ['index','create','store', 'edit']]);


	Route::resource('/expedientes','ExpedientesController');
		Route::get('expedientes/{id}/destroy', [
				'uses' => 'ExpedientesController@destroy',
				'as' =>  'expedientes.destroy'
			]);	
		Route::post('expedientes/actualiza', [
				'uses' => 'ExpedientesController@actualiza',
				'as' =>  'expedientes.actualiza'
			]);

		Route::post('expedientes/buscarencabezado', [
				'uses' => 'ExpedientesController@buscarencabezado',
				'as' =>  'expedientes.buscarencabezado'
			]);


		Route::get('detalle/expediente', [
				'uses' => 'DetalleController@expedientes',
				'as' =>  'detalles.expediente'
			]);	


		

		Route::get('detalle/exped/nuevo', [
				'uses' => 'DetalleController@nuevo',
				'as' =>  'detalles.nuevo'
			]);	

			Route::post('/detalle/actualiza', [
				'uses' => 'DetalleController@actualiza',
				'as' =>  'detalle.actualiza'
			]);

		Route::resource('/detalle','DetalleController');


	Route::resource('/archivo','ArchivoController');
		Route::get('archivo/{id}/destroy', [
				'uses' => 'ArchivoController@destroy',
				'as' =>  'archivo.destroy'
			]);	
		Route::post('archivo/actualiza', [
				'uses' => 'ArchivoController@actualiza',
				'as' =>  'archivo.actualiza'
			]);


	
		Route::get('fuid/{id}/destroy', [
				'uses' => 'FuidController@destroy',
				'as' =>  'fuid.destroy'
			]);	
		Route::post('fuid/actualiza', [
				'uses' => 'FuidController@actualiza',
				'as' =>  'fuid.actualiza'
			]);
		Route::get('fuid/etiquetas', [
				'uses' => 'FuidController@etiquetas',
				'as' =>  'fuid.etiquetas'
			]);
				Route::get('fuid/etiquetasfuid', [
				'uses' => 'FuidController@etiquetasfuid',
				'as' =>  'fuid.etiquetasfuid'
			]);
		Route::post('fuid/pdf', [
				'uses' => 'FuidController@pdf',
				'as' =>  'fuid.pdf'
			]);
		Route::post('fuid/datos', [
				'uses' => 'FuidController@datos',
				'as' =>  'fuid.datos'
			]);
	Route::resource('/fuid','FuidController', ['only'=> ['index','create','store', 'edit']]);

		Route::resource('excel/{orga}/{seri}/','ExcelController');


		Route::resource('/pdf','PdfController');
		Route::get('pdf/{id}/{id2}/trd', [
				'uses' => 'PdfController@trd',
				'as' =>  'pdf.trd'
			]);	

			
		Route::get('meta/{id}/destroy', [
				'uses' => 'MetaController@destroy',
				'as' =>  'meta.destroy'
			]);
		Route::post('meta/actualizar', [
				'uses' => 'MetaController@actualizar',
				'as' =>  'meta.actualizar'
			]);
		Route::post('meta/subserie', [
				'uses' => 'MetaController@subserie',
				'as' =>  'meta.subserie'
			]);
		Route::post('meta/seleccion', [
				'uses' => 'MetaController@seleccion',
				'as' =>  'meta.seleccion'
			]);
		Route::resource('/meta','MetaController');


		Route::resource('/prestamo','PrestamosController', ['only'=> ['index','create','store', 'edit']]);
		Route::get('prestamo/{id}/destroy', [
				'uses' => 'PrestamosController@destroy',
				'as' =>  'prestamo.destroy'
			]);
		Route::post('prestamo/actualizar', [
				'uses' => 'PrestamosController@actualizar',
				'as' =>  'prestamo.actualizar'
			]);

		Route::post('prestamo/detalle', [
				'uses' => 'PrestamosController@detalle',
				'as' =>  'prestamo.detalle'
			]);
		Route::post('prestamo/prestamo', [
				'uses' => 'PrestamosController@prestamo',
				'as' =>  'prestamo.prestamo'
			]);

		Route::post('prestamo/editardetalle', [
				'uses' => 'PrestamosController@editardetalle',
				'as' =>  'prestamo.editardetalle'
			]);
		Route::post('prestamo/actualizaritem', [
				'uses' => 'PrestamosController@actualizaritem',
				'as' =>  'prestamo.actualizaritem'
			]);
		Route::post('prestamo/actualizaarray', [
				'uses' => 'PrestamosController@actualizaarray',
				'as' =>  'prestamo.actualizaarray'
			]);

		Route::post('prestamo/pdf', [
				'uses' => 'PrestamosController@pdf',
				'as' =>  'prestamo.pdf'
			]);

		Route::get('prestamo/{id}/entrega', [
				'uses' => 'PrestamosController@entrega',
				'as' =>  'prestamo.entrega'
			]);

		Route::post('prestamo/devolver', [
				'uses' => 'PrestamosController@devolver',
				'as' =>  'prestamo.devolver'
			]);


		Route::resource('/barras','BarraController');