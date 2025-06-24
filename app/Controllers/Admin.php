<?php

namespace App\Controllers;

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\PedidosController;
use App\Controllers\Admin\UsuariosController;
use App\Controllers\Admin\ProductosController;
use App\Controllers\Admin\CategoriasController;

/**
 * Controlador Admin simplificado que delega a controladores específicos
 * Mantiene compatibilidad con rutas existentes
 */
class Admin extends BaseController
{
    private $dashboardController;
    private $usuariosController;
    private $productosController;
    private $categoriasController;
    private $pedidosController;

    public function __construct()
    {
        $this->dashboardController = new DashboardController();
        $this->usuariosController = new UsuariosController();
        $this->productosController = new ProductosController();
        $this->categoriasController = new CategoriasController();
        $this->pedidosController = new PedidosController();
    }

    // =============================================
    // DASHBOARD
    // =============================================
    public function dashboard()
    {
        return $this->dashboardController->index();
    }

    public function getStats()
    {
        return $this->dashboardController->getStats();
    }

    // =============================================
    // USUARIOS - VISTAS
    // =============================================
    public function usuarios()
    {
        return $this->usuariosController->index();
    }

    public function usuariosCrear()
    {
        return $this->usuariosController->crear();
    }

    public function usuariosEditar($id)
    {
        return $this->usuariosController->editar($id);
    }

    public function usuariosVer($id)
    {
        return $this->usuariosController->ver($id);
    }

    // USUARIOS - APIs
    public function getUsuarios()
    {
        return $this->usuariosController->getUsuarios();
    }

    public function crearUsuario()
    {
        return $this->usuariosController->crearUsuario();
    }

    public function getUsuario($id)
    {
        return $this->usuariosController->getUsuario($id);
    }

    public function actualizarUsuario($id)
    {
        return $this->usuariosController->actualizarUsuario($id);
    }

    public function eliminarUsuario($id)
    {
        return $this->usuariosController->eliminarUsuario($id);
    }

    public function getRoles()
    {
        return $this->usuariosController->getRoles();
    }

    // API: Cambiar estado de baja/activo de un usuario
    public function cambiarEstadoBajaUsuario($id)
    {
        return $this->usuariosController->cambiarEstadoBajaUsuario($id);
    }

    // =============================================
    // PRODUCTOS - VISTAS
    // =============================================
    public function productos()
    {
        return $this->productosController->index();
    }

    public function productosCrear()
    {
        return $this->productosController->crear();
    }

    public function productosEditar($id)
    {
        return $this->productosController->editar($id);
    }

    public function productosVer($id)
    {
        return $this->productosController->ver($id);
    }

    // PRODUCTOS - APIs
    public function getProductos()
    {
        return $this->productosController->getProductos();
    }

    public function crearProducto()
    {
        return $this->productosController->crearProducto();
    }

    public function getProducto($id)
    {
        return $this->productosController->getProducto($id);
    }

    public function actualizarProducto($id)
    {
        return $this->productosController->actualizarProducto($id);
    }
    public function eliminarProducto($id)
    {
        return $this->productosController->eliminarProducto($id);
    }

    public function toggleProductoActivo($id)
    {
        return $this->productosController->toggleActivo($id);
    }

    // =============================================
    // CATEGORÍAS - VISTAS
    // =============================================
    public function categorias()
    {
        return $this->categoriasController->index();
    }

    public function categoriasCrear()
    {
        return $this->categoriasController->crear();
    }

    public function categoriasEditar($id)
    {
        return $this->categoriasController->editar($id);
    }

    // CATEGORÍAS - APIs
    public function getCategoriasAdmin()
    {
        return $this->categoriasController->getCategoriasAdmin();
    }

    public function getCategorias()
    {
        return $this->categoriasController->getCategorias();
    }

    public function crearCategoria()
    {
        return $this->categoriasController->crearCategoria();
    }
    public function getCategoria($id)
    {
        return $this->categoriasController->getCategoria($id);
    }

    public function actualizarCategoria($id)
    {
        return $this->categoriasController->actualizarCategoria($id);
    }
    public function eliminarCategoria($id)
    {
        return $this->categoriasController->eliminarCategoria($id);
    }

    public function toggleCategoriaActiva($id)
    {
        return $this->categoriasController->toggleActiva($id);
    }

    // =============================================
    // PEDIDOS - VISTAS
    // =============================================
    public function pedidos()
    {
        return $this->pedidosController->index();
    }

    public function pedidosEditar($id)
    {
        return $this->pedidosController->editar($id);
    }

    public function pedidosVer($id)
    {
        return $this->pedidosController->ver($id);
    }

    // PEDIDOS - APIs
    public function getPedidos()
    {
        return $this->pedidosController->getPedidos();
    }

    public function getPedido($id)
    {
        return $this->pedidosController->getPedido($id);
    }

    public function getProductosPedido($id)
    {
        return $this->pedidosController->getProductosPedido($id);
    }

    public function actualizarPedido($id)
    {
        return $this->pedidosController->actualizarPedido($id);
    }

    public function eliminarPedido($id)
    {
        return $this->pedidosController->eliminarPedido($id);
    }
}
