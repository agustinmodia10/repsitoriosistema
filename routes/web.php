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

Route::group(array('domain' => 'esencias'), function()
{
    Route::get('/', 'ControladorEsenciasHome@index');
    Route::get('/esencia/{id}', 'ControladorEsenciasDescripcion@index');
    Route::get('/contacto', 'ControladorEsenciasContacto@index');
});

Route::get('/', 'ControladorEsenciasHome@index');
Route::get('/esencia/{id}', 'ControladorEsenciasDescripcion@index');
Route::get('/contacto', 'ControladorEsenciasContacto@index');
Route::get('/informe', 'ControladorEsenciasInforme@index');
Route::get('producto/agregarAlCarrito', 'ControladorEsenciasHome@agregarAlCarrito');




  Route::group(array('domain' => 'sistema'), function()
{

Route::get('/', 'ControladorHome@index');
Route::get('/legajo', 'ControladorLegajo@index');


Route::get('/home', 'ControladorHome@index');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                             */
/* --------------------------------------------- */
Route::get('/login', 'ControladorLogin@index');
Route::get('/logout', 'ControladorLogin@logout');
Route::post('/logout', 'ControladorLogin@entrar');
Route::post('/login', 'ControladorLogin@entrar');


/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
Route::get('/recupero-clave', 'ControladorRecuperoClave@index');
Route::post('/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
Route::get('/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
Route::get('/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
Route::get('/permisos', 'ControladorPermiso@index');
Route::get('/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
Route::get('/permiso/nuevo', 'ControladorPermiso@nuevo');
Route::get('/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
Route::get('/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
Route::get('/permiso/{idpermiso}', 'ControladorPermiso@editar');
Route::post('/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
Route::get('/grupos', 'ControladorGrupo@index');
Route::get('/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
Route::get('/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
Route::get('/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
Route::get('/grupo/nuevo', 'ControladorGrupo@nuevo');
Route::get('/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
Route::post('/grupo/nuevo', 'ControladorGrupo@guardar');
Route::get('/grupo/{idgrupo}', 'ControladorGrupo@editar');
Route::post('/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
Route::get('/usuarios', 'ControladorUsuario@index');
Route::get('/usuarios/nuevo', 'ControladorUsuario@nuevo');
Route::post('/usuarios/nuevo', 'ControladorUsuario@guardar');
Route::post('/usuarios/{usuario}', 'ControladorUsuario@guardar');
Route::get('/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
Route::get('/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
Route::get('/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */
Route::get('/sistema/menu', 'ControladorMenu@index');
Route::get('/sistema/menu/nuevo', 'ControladorMenu@nuevo');
Route::post('/sistema/menu/nuevo', 'ControladorMenu@guardar');
Route::get('/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
Route::get('/sistema/menu/eliminar', 'ControladorMenu@eliminar');
Route::get('/sistema/menu/{id}', 'ControladorMenu@editar');
Route::post('/sistema/menu/{id}', 'ControladorMenu@guardar');
Route::get('/sistema/menu/{id}', 'ControladorMenu@editar');

/* --------------------------------------------- */
/* CONTROLADOR SINTOMAS                             */
/* --------------------------------------------- */
Route::get('/sintomas', 'ControladorSintoma@index');
Route::get('/sintoma/cargarGrilla', 'ControladorSintoma@cargarGrilla')->name('sintoma.cargarGrilla');
Route::get('/sintoma/nuevo', 'ControladorSintoma@nuevo');
Route::post('/sintoma/nuevo', 'ControladorSintoma@guardar');
Route::get('/sintoma/eliminar', 'ControladorSintoma@eliminar');
Route::get('/sintoma/{id}', 'ControladorSintoma@editar');
Route::post('/sintoma/{id}', 'ControladorSintoma@guardar');
Route::get('/sintoma/{id}', 'ControladorSintoma@editar');

/* --------------------------------------------- */
/* CONTROLADOR PRODUCTOS                             */
/* --------------------------------------------- */
Route::get('/productos', 'ControladorProducto@index');
Route::get('/producto/cargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');
Route::get('/producto/nuevo', 'ControladorProducto@nuevo');
Route::post('/producto/nuevo', 'ControladorProducto@guardar');
Route::get('/producto/eliminar', 'ControladorProducto@eliminar');

Route::get('/producto/marcas', 'ControladorMarca@index');
Route::get('/producto/marca/cargarGrilla', 'ControladorMarca@cargarGrilla')->name('producto-marca.cargarGrilla');
Route::get('/producto/marca/nuevo', 'ControladorMarca@nuevo');
Route::post('/producto/marca/nuevo', 'ControladorMarca@guardar');
Route::get('/producto/marca/{id}', 'ControladorMarca@editar');
Route::post('/producto/marca/{id}', 'ControladorMarca@guardar');

Route::get('/producto/tipos', 'ControladorTipo@index');
Route::get('/producto/tipo/cargarGrilla', 'ControladorTipo@cargarGrilla')->name('producto-tipo.cargarGrilla');
Route::get('/producto/tipo/nuevo', 'ControladorTipo@nuevo');
Route::post('/producto/tipo/nuevo', 'ControladorTipo@guardar');
Route::get('/producto/tipo/{id}', 'ControladorTipo@editar');
Route::post('/producto/tipo/{id}', 'ControladorTipo@guardar');

Route::get('/producto/{id}', 'ControladorProducto@editar');
Route::post('/producto/{id}', 'ControladorProducto@guardar');

/* --------------------------------------------- */
/* CONTROLADOR PAGINAS                             */
/* --------------------------------------------- */
Route::get('/paginas', 'ControladorPagina@index');
Route::get('/pagina/cargarGrilla', 'ControladorPagina@cargarGrilla')->name('pagina.cargarGrilla');
Route::get('/pagina/nuevo', 'ControladorPagina@nuevo');
Route::post('/pagina/nuevo', 'ControladorPagina@guardar');
Route::get('/pagina/eliminar', 'ControladorPagina@eliminar');
Route::get('/pagina/{id}', 'ControladorPagina@editar');
Route::post('/pagina/{id}', 'ControladorPagina@guardar');

/* --------------------------------------------- */
/* CONTROLADOR FOOTER                            */
/* --------------------------------------------- */
Route::get('/configuracion/footer', 'ControladorFooter@index');
Route::get('/configuracion/footer/cargarGrilla', 'ControladorFooter@cargarGrilla')->name('footer.cargarGrilla');
Route::get('/configuracion/footer/nuevo', 'ControladorFooter@nuevo');
Route::post('/configuracion/footer/nuevo', 'ControladorFooter@guardar');
Route::get('/configuracion/footer/eliminar', 'ControladorFooter@eliminar');
Route::get('/configuracion/footer/{id}', 'ControladorFooter@editar');
Route::post('/configuracion/footer/{id}', 'ControladorFooter@guardar');
Route::get('/configuracion/footer/{id}', 'ControladorFooter@editar');



/* --------------------------------------------- */
/* CONTROLADOR CONFIGURACIONES                   */
/* --------------------------------------------- */

Route::get('/configuracion/general', 'ControladorConfiguracion@index');
Route::get('/configuracion/general/cargarGrilla', 'ControladorConfiguracion@cargarGrilla')->name('configuracion.cargarGrilla');
Route::get('/configuracion/nuevo', 'ControladorConfiguracion@nuevo');
Route::post('/configuracion/nuevo', 'ControladorConfiguracion@guardar');
Route::get('/configuracion/eliminar', 'ControladorConfiguracion@eliminar');
Route::get('/configuracion/{id}', 'ControladorConfiguracion@editar');
Route::post('/configuracion/{id}', 'ControladorConfiguracion@guardar');



});

