<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==================================
// RUTAS DE INICIALIZACIÓN Y DESARROLLO
// ==================================
$routes->get('/init-db', 'InitDB::init'); // Inicializar BD con roles y admin
$routes->get('test-checkout', 'Home::testCheckout'); // Ruta de prueba del sistema de checkout
$routes->get('init-metodos-pago', 'Checkout::initMetodosPago');
$routes->get('checkout/init-metodos-pago', 'Checkout::initMetodosPago');
$routes->get('checkout/debug-session', 'Checkout::debugSession'); // Ruta temporal para debug

// ==================================
// RUTAS PÚBLICAS - HOME Y PÁGINAS
// ==================================
$routes->get('/', 'Home::index');
$routes->get('quienes-somos', 'Home::about');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->post('contacto/enviar', 'Home::enviarContacto');
$routes->get('terminos', 'Home::terminos');
$routes->get('catalogo', 'Home::catalogo');
$routes->get('consultas', 'Home::consultas');

// ==================================
// RUTAS DE PRODUCTOS
// ==================================
$routes->get('productos', 'Productos::index');
$routes->get('productos/(:num)', 'Productos::ver/$1');
$routes->get('productos/categoria/(:segment)', 'Productos::categoria/$1');
$routes->get('productos/buscar', 'Productos::buscar');
$routes->get('productos/api', 'Productos::api');

// ==================================
// RUTAS DE AUTENTICACIÓN
// ==================================
$routes->get('registro', 'Auth::registro');
$routes->post('registro/procesar', 'Auth::procesarRegistro');
$routes->get('login', 'Auth::login');
$routes->post('login/procesar', 'Auth::procesarLogin');
$routes->get('logout', 'Auth::logout');

// ==================================
// RUTAS PROTEGIDAS - PERFIL DE USUARIO
// ==================================
$routes->group('perfil', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Auth::perfil');
    $routes->get('editar', 'Auth::perfilEditar');
    $routes->post('actualizar', 'Auth::actualizarPerfil');
});

// ==================================
// RUTAS PROTEGIDAS - CARRITO DE COMPRAS
// ==================================
$routes->get('carrito', 'Carrito::index', ['filter' => 'auth']);
$routes->post('carrito/agregar', 'Carrito::agregar');
$routes->post('carrito/actualizar', 'Carrito::actualizar');
$routes->get('carrito/eliminar/(:num)', 'Carrito::eliminar/$1', ['filter' => 'auth']);
$routes->get('carrito/limpiar', 'Carrito::limpiar', ['filter' => 'auth']);
$routes->get('carrito/conteo', 'Carrito::conteo');

// ==================================
// RUTAS PROTEGIDAS - CHECKOUT Y PEDIDOS
// ==================================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Checkout
    $routes->get('checkout', 'Checkout::index');
    $routes->post('checkout/procesar', 'Checkout::procesar');

    // Facturas
    $routes->get('factura/(:num)', 'Checkout::factura/$1');
    $routes->get('checkout/factura/(:num)', 'Checkout::factura/$1'); // Ruta alternativa

    // Mis pedidos
    $routes->get('mis-pedidos', 'Checkout::misPedidos');
    $routes->get('pedido/(:num)', 'Checkout::verPedido/$1');
});

// ==================================
// PANEL DE ADMINISTRACIÓN
// ==================================

// Dashboard principal
$routes->get('admin', 'Admin::dashboard', ['filter' => 'admin']);

// Gestión de usuarios
$routes->group('admin/usuarios', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin::usuarios');
    $routes->get('crear', 'Admin::usuariosCrear');
    $routes->get('editar/(:num)', 'Admin::usuariosEditar/$1');
});

// Gestión de productos
$routes->group('admin/productos', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin::productos');
    $routes->get('crear', 'Admin::productosCrear');
    $routes->get('editar/(:num)', 'Admin::productosEditar/$1');
});

// Gestión de categorías
$routes->group('admin/categorias', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin::categorias');
    $routes->get('crear', 'Admin::categoriasCrear');
    $routes->get('editar/(:num)', 'Admin::categoriasEditar/$1');
});

// Gestión de pedidos
$routes->group('admin/pedidos', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin::pedidos');
    $routes->get('ver/(:num)', 'Admin::pedidosVer/$1');
    $routes->get('editar/(:num)', 'Admin::pedidosEditar/$1'); // Mantener por compatibilidad
});

// ==================================
// APIs DEL PANEL DE ADMINISTRACIÓN
// ==================================
$routes->group('admin/api', ['filter' => 'admin'], function ($routes) {
    // APIs de usuarios
    $routes->get('usuarios', 'Admin::getUsuarios');
    $routes->post('usuario', 'Admin::crearUsuario');
    $routes->get('usuario/(:num)', 'Admin::getUsuario/$1');
    $routes->put('usuario/(:num)', 'Admin::actualizarUsuario/$1');
    $routes->post('usuario/(:num)', 'Admin::actualizarUsuario/$1'); // Fallback para PUT
    $routes->delete('usuario/(:num)', 'Admin::eliminarUsuario/$1');
    $routes->get('roles', 'Admin::getRoles');

    // APIs de productos
    $routes->get('productos', 'Admin::getProductos');
    $routes->post('producto', 'Admin::crearProducto');
    $routes->get('producto/(:num)', 'Admin::getProducto/$1');
    $routes->put('producto/(:num)', 'Admin::actualizarProducto/$1');
    $routes->post('producto/(:num)', 'Admin::actualizarProducto/$1'); // Fallback para PUT
    $routes->delete('producto/(:num)', 'Admin::eliminarProducto/$1');
    $routes->put('producto/(:num)/toggle', 'Admin::toggleProductoActivo/$1');
    $routes->post('producto/(:num)/toggle', 'Admin::toggleProductoActivo/$1'); // Fallback para PUT

    // APIs de categorías
    $routes->get('categorias/activas', 'Admin::getCategorias');
    $routes->get('categorias/(:num)', 'Admin::getCategoria/$1');
    $routes->get('categorias', 'Admin::getCategoriasAdmin');
    $routes->post('categorias', 'Admin::crearCategoria');
    $routes->put('categorias/(:num)', 'Admin::actualizarCategoria/$1');
    $routes->post('categorias/(:num)', 'Admin::actualizarCategoria/$1'); // Fallback para PUT
    $routes->delete('categorias/(:num)', 'Admin::eliminarCategoria/$1');
    $routes->put('categorias/(:num)/toggle', 'Admin::toggleCategoriaActiva/$1');
    $routes->post('categorias/(:num)/toggle', 'Admin::toggleCategoriaActiva/$1'); // Fallback para PUT

    // APIs de pedidos y estadísticas
    $routes->get('pedidos', 'Admin::getPedidos');
    $routes->get('pedido/(:num)', 'Admin::getPedido/$1');
    $routes->get('pedido/(:num)/productos', 'Admin::getProductosPedido/$1');
    $routes->put('pedido/(:num)', 'Admin::actualizarPedido/$1');
    $routes->post('pedido/(:num)', 'Admin::actualizarPedido/$1'); // Fallback para PUT
    $routes->delete('pedido/(:num)', 'Admin::eliminarPedido/$1');
    $routes->get('stats', 'Admin::getStats');
});
