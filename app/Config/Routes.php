<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('login', 'Home::login');
$routes->post('cam-cla', 'Home::camClave');
$routes->get('panel', 'Home::panel');
$routes->get('registro', 'Home::registro');
$routes->post('reg-for', 'Home::nuevoRegistro');
$routes->post('rep-hor', 'Home::reporteHorario');
$routes->get('salir', 'Home::salir');
$routes->get('usuario', 'Home::usuario');
$routes->post('new-usu', 'Home::nuevoUsuario');
$routes->post('edi-usu', 'Home::editarUsuario');
$routes->get('eli-usu', 'Home::eliminarUsuario');
$routes->get('acc-usu', 'Home::accesoUsuario');
$routes->get('area', 'Home::areas');
$routes->post('new-are', 'Home::nuevaArea');
$routes->post('edi-are', 'Home::editarArea');
$routes->get('eli-are', 'Home::eliminarArea');
$routes->get('institucion', 'Home::institucion');
$routes->post('new-ins', 'Home::nuevaInstitucion');
$routes->post('edi-ins', 'Home::editarInstitucion');
$routes->get('eli-ins', 'Home::eliminarInstitucion');
$routes->get('asi-usu', 'Home::asistencia');
$routes->post('new-asi', 'Home::nuevoAsistencia');
$routes->post('edi-asi', 'Home::editarAsistencia');
$routes->get('eli-asi', 'Home::eliminarAsistencia');
$routes->post('ajx', 'Home::AJAX');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
