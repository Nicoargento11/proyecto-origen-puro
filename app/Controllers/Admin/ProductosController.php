<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Traits\AdminHelpers;

class ProductosController extends BaseController
{
    use AdminHelpers;

    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    // =============================================
    // VISTAS
    // =============================================

    public function index()
    {
        $data = [
            'title' => 'Gestión de Productos',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/productos/index', $data);
    }

    public function crear()
    {
        $data = [
            'title' => 'Crear Producto',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/productos/crear', $data);
    }

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }

        $data = [
            'title' => 'Editar Producto',
            'user' => $this->getAdminUserData(),
            'producto' => $producto
        ];

        return view('admin/productos/editar', $data);
    }

    public function ver($id)
    {
        $producto = $this->productoModel->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.id', $id)
            ->first();

        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }

        $data = [
            'title' => 'Ver Producto',
            'user' => $this->getAdminUserData(),
            'producto' => $producto
        ];

        return view('admin/productos/ver', $data);
    }    // =============================================
    // APIs
    // =============================================

    public function getProductos()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $productos = $this->productoModel->select('productos.*, categorias.nombre as categoria_nombre')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->orderBy('productos.nombre')
                ->findAll();            // Procesar rutas de imagen
            foreach ($productos as &$producto) {
                if (!empty($producto['imagen_producto'])) {
                    // Si la imagen ya incluye la ruta uploads/productos, usar tal como está
                    $producto['imagen'] = base_url('public/uploads/productos/' . $producto['imagen_producto']);
                } else {
                    $producto['imagen'] = null;
                }
            }
            return $this->sendJsonResponse(true, 'Productos obtenidos exitosamente', $productos);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener productos');
        }
    }
    public function crearProducto()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $rules = [
                'nombre' => 'required|min_length[3]|max_length[255]',
                'precio' => 'required|decimal|greater_than[0]',
                'categoria_id' => 'required|integer',
                'stock' => 'required|integer|greater_than_equal_to[0]'
            ];

            // Usar el servicio de validation directamente
            $validation = service('validation');
            $request = $this->request ?? service('request');

            if (!$validation->withRequest($request)->setRules($rules)->run()) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $validation->getErrors()
                ]);
            }
            $productData = [
                'nombre' => trim($request->getPost('nombre')),
                'descripcion' => trim($request->getPost('descripcion') ?: ''),
                'precio' => floatval($request->getPost('precio')),
                'categoria_id' => intval($request->getPost('categoria_id')),
                'stock' => intval($request->getPost('stock')),
                'activo' => intval($request->getPost('activo')),
                'destacado' => intval($request->getPost('destacado')),
                // Campos específicos del café
                'origen' => trim($request->getPost('origen') ?: ''),
                'proceso' => trim($request->getPost('proceso') ?: ''),
                'tostacion' => trim($request->getPost('tostacion') ?: ''),
                'puntuacion' => floatval($request->getPost('puntuacion') ?: 0),
                'notas_cata' => trim($request->getPost('notas_cata') ?: '')
            ];

            // Manejo de imagen
            $imagen = $request->getFile('imagen_producto');
            if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(WRITEPATH . '../public/uploads/productos', $nombreImagen);
                $productData['imagen_producto'] = $nombreImagen;
            }
            $productoId = $this->productoModel->insert($productData);

            if ($productoId) {
                return $this->sendJsonResponse(true, 'Producto creado exitosamente', [
                    'producto_id' => $productoId
                ]);
            } else {
                return $this->sendJsonResponse(false, 'Error al crear el producto');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al crear producto');
        }
    }

    public function getProducto($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $producto = $this->productoModel->select('productos.*, categorias.nombre as categoria_nombre')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->where('productos.id', $id)
                ->first();

            if (!$producto) {
                return $this->sendJsonResponse(false, 'Producto no encontrado');
            }
            return $this->sendJsonResponse(true, 'Producto obtenido exitosamente', $producto);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener producto');
        }
    }
    public function actualizarProducto($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $producto = $this->productoModel->find($id);
            if (!$producto) {
                return $this->sendJsonResponse(false, 'Producto no encontrado');
            }

            $rules = [
                'nombre' => 'required|min_length[3]|max_length[255]',
                'precio' => 'required|decimal|greater_than[0]',
                'categoria_id' => 'required|integer',
                'stock' => 'required|integer|greater_than_equal_to[0]'
            ];

            // Usar el servicio de validation directamente
            $validation = service('validation');
            $request = $this->request ?? service('request');

            if (!$validation->withRequest($request)->setRules($rules)->run()) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $validation->getErrors()
                ]);
            }
            $updateData = [
                'nombre' => trim($request->getPost('nombre')),
                'descripcion' => trim($request->getPost('descripcion') ?: ''),
                'precio' => floatval($request->getPost('precio')),
                'categoria_id' => intval($request->getPost('categoria_id')),
                'stock' => intval($request->getPost('stock')),
                'activo' => intval($request->getPost('activo')),
                'destacado' => intval($request->getPost('destacado')),
                // Campos específicos del café
                'origen' => trim($request->getPost('origen') ?: ''),
                'proceso' => trim($request->getPost('proceso') ?: ''),
                'tostacion' => trim($request->getPost('tostacion') ?: ''),
                'puntuacion' => floatval($request->getPost('puntuacion') ?: 0),
                'notas_cata' => trim($request->getPost('notas_cata') ?: '')
            ]; // Manejo de nueva imagen
            $imagen = $request->getFile('imagen_producto');
            if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                // Eliminar imagen anterior si existe
                if ($producto['imagen_producto']) {
                    // Si la imagen ya tiene la ruta completa, extraer solo el nombre
                    $nombreArchivoAnterior = str_replace('uploads/productos/', '', $producto['imagen_producto']);
                    $rutaImagenAnterior = WRITEPATH . '../public/uploads/productos/' . $nombreArchivoAnterior;
                    if (file_exists($rutaImagenAnterior)) {
                        unlink($rutaImagenAnterior);
                    }
                }
                $nombreImagen = $imagen->getRandomName();
                $imagen->move(WRITEPATH . '../public/uploads/productos', $nombreImagen);
                $updateData['imagen_producto'] = "uploads/productos/" . $nombreImagen;
            }

            $success = $this->productoModel->update($id, $updateData);

            if ($success) {
                return $this->sendJsonResponse(true, 'Producto actualizado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al actualizar el producto');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al actualizar producto');
        }
    }

    public function eliminarProducto($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $producto = $this->productoModel->find($id);
            if (!$producto) {
                return $this->sendJsonResponse(false, 'Producto no encontrado');
            }

            // Eliminar imagen si existe
            if ($producto['imagen_producto']) {
                $rutaImagen = WRITEPATH . '../public/uploads/productos/' . $producto['imagen_producto'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $success = $this->productoModel->delete($id);
            if ($success) {
                return $this->sendJsonResponse(true, 'Producto eliminado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al eliminar el producto');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al eliminar producto');
        }
    }
    /**
     * Toggle estado activo/inactivo del producto
     */
    public function toggleActivo($id)
    {
        try {
            $producto = $this->productoModel->find($id);
            if (!$producto) {
                return $this->sendJsonResponse(false, 'Producto no encontrado');
            }

            // Cambiar el estado
            $nuevoEstado = $producto['activo'] == 1 ? 0 : 1;
            $success = $this->productoModel->update($id, ['activo' => $nuevoEstado]);

            if ($success) {
                $mensaje = $nuevoEstado == 1 ? 'Producto activado exitosamente' : 'Producto desactivado exitosamente';
                return $this->sendJsonResponse(true, $mensaje, [
                    'nuevo_estado' => $nuevoEstado,
                    'texto_estado' => $nuevoEstado == 1 ? 'Activo' : 'Inactivo'
                ]);
            } else {
                return $this->sendJsonResponse(false, 'Error al cambiar el estado del producto');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en toggleActivo: ' . $e->getMessage());
            return $this->handleException($e, 'Error al cambiar estado del producto');
        }
    }
}
