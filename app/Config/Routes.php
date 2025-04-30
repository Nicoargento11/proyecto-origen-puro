<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('quienes-somos', 'Home::about');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->post('contacto/enviar', 'Home::enviarContacto'); // Nueva ruta POST
$routes->get('terminos', 'Home::terminos');
$routes->get('catalogo', 'Home::catalogo');
$routes->get('consultas', 'Home::consultas');
