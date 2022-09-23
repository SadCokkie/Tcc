<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Index 
$routes->get('/','Inicio::index');
$routes->get('/botoes', function(){
	return view('examples/ui-buttons');
});

//USUÁRIOS
$routes->post('/login', 'Usuarios::login');
$routes->post('/logar', 'Usuarios::logar');
$routes->post('/alterar_senha/(:any)', 'Usuarios::alterar_senha/$1');
$routes->post('/salvar_alteracao_senha', 'Usuarios::salvar_alteracao_senha');
$routes->get('usuarios/(:any)'      , 'Usuarios::buscar/$1');
$routes->post('usuarios/'           , 'Usuarios::criar');
$routes->patch('usuarios/(:any)'    , 'Usuarios::editar/$1');
$routes->delete('usuarios/(:any)'   , 'Usuarios::excluir/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
