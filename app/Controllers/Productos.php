<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Productos extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();

        // Cargar helpers necesarios
        helper(['text', 'url']);
    }

    // Página principal de productos
    public function index()
    {
        $productos = $this->productoModel->getProductosActivos();
        $categorias = $this->categoriaModel->getCategoriasActivas();

        $data = [
            'title' => 'Nuestros Cafés | Origen Puro',
            'productos' => $productos,
            'categorias' => $categorias
        ];

        return view('templates/header', $data)
            . view('productos/catalogo', $data)
            . view('templates/footer');
    }

    // Ver producto individual
    public function ver($id)
    {
        $producto = $this->productoModel->getProductoCompleto($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Productos relacionados de la misma categoría
        $relacionados = $this->productoModel->getProductosPorCategoria($producto['categoria_id']);
        // Filtrar el producto actual
        $relacionados = array_filter($relacionados, function ($p) use ($id) {
            return $p['id'] != $id;
        });
        $relacionados = array_slice($relacionados, 0, 4); // Solo 4 relacionados

        $data = [
            'title' => $producto['nombre'] . ' | Origen Puro',
            'producto' => $producto,
            'relacionados' => $relacionados
        ];

        return view('templates/header', $data)
            . view('productos/detalle', $data)
            . view('templates/footer');
    }

    // Productos por categoría
    public function categoria($slug)
    {
        $categoria = $this->categoriaModel->getPorSlug($slug);

        if (!$categoria) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $productos = $this->productoModel->getProductosPorCategoria($categoria['id']);
        $categorias = $this->categoriaModel->getCategoriasActivas();

        $data = [
            'title' => $categoria['nombre'] . ' | Origen Puro',
            'categoria' => $categoria,
            'productos' => $productos,
            'categorias' => $categorias
        ];

        return view('templates/header', $data)
            . view('productos/categoria', $data)
            . view('templates/footer');
    }    // Búsqueda de productos
    public function buscar()
    {
        $termino = $this->request->getGet('q');

        if (empty($termino)) {
            return redirect()->to('/productos');
        }

        $productos = $this->productoModel->buscarProductos($termino);
        $categorias = $this->categoriaModel->getCategoriasActivas();

        $data = [
            'title' => 'Búsqueda: ' . $termino . ' | Origen Puro',
            'termino' => $termino,
            'productos' => $productos,
            'categorias' => $categorias,
            'busqueda_activa' => true,
            'total_resultados' => count($productos)
        ];

        return view('templates/header', $data)
            . view('productos/catalogo', $data)
            . view('templates/footer');
    }    // API para obtener productos (para AJAX)
    public function api()
    {
        try {
            $categoria = $this->request->getGet('categoria');
            $destacados = $this->request->getGet('destacados');

            if ($destacados) {
                $productos = $this->productoModel->getProductosDestacados();
            } elseif ($categoria) {
                $productos = $this->productoModel->getProductosPorCategoria($categoria);
            } else {
                $productos = $this->productoModel->getProductosActivos();
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Productos obtenidos exitosamente',
                'data' => $productos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al obtener productos: ' . $e->getMessage()
            ]);
        }
    }
}
