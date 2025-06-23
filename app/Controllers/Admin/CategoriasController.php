<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use App\Traits\AdminHelpers;

class CategoriasController extends BaseController
{
    use AdminHelpers;

    protected $categoriaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->productoModel = new ProductoModel();
    }

    // =============================================
    // VISTAS
    // =============================================

    public function index()
    {
        $data = [
            'title' => 'Gestión de Categorías',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/categorias/index', $data);
    }

    public function crear()
    {
        $data = [
            'title' => 'Crear Categoría',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/categorias/crear', $data);
    }

    public function editar($id)
    {
        $categoria = $this->categoriaModel->find($id);
        if (!$categoria) {
            return redirect()->to('/admin/categorias')->with('error', 'Categoría no encontrada');
        }

        $data = [
            'title' => 'Editar Categoría',
            'user' => $this->getAdminUserData(),
            'categoria' => $categoria
        ];

        return view('admin/categorias/editar', $data);
    }

    // =============================================
    // APIs
    // =============================================

    public function getCategoriasAdmin()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            // Obtener categorías con conteo de productos
            $categorias = $this->categoriaModel
                ->select('categorias.*, COUNT(productos.id) as productos_count')
                ->join('productos', 'productos.categoria_id = categorias.id', 'left')
                ->groupBy('categorias.id')
                ->orderBy('categorias.nombre')
                ->findAll();
            return $this->sendJsonResponse(true, 'Categorías obtenidas exitosamente', $categorias);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener categorías');
        }
    }

    public function getCategorias()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $categorias = $this->categoriaModel->where('activa', 1)
                ->orderBy('nombre')
                ->findAll();
            return $this->sendJsonResponse(true, 'Categorías activas obtenidas exitosamente', $categorias);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener categorías');
        }
    }
    public function crearCategoria()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $rules = [
                'nombre' => 'required|min_length[3]|max_length[100]|is_unique[categorias.nombre]'
            ];

            // Usar el servicio de validation directamente para evitar problemas con el request
            $validation = service('validation');
            $request = $this->request ?? service('request');

            if (!$validation->withRequest($request)->setRules($rules)->run()) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $validation->getErrors()
                ]);
            }

            $categoriaData = [
                'nombre' => trim($request->getPost('nombre')),
                'descripcion' => trim($request->getPost('descripcion') ?: ''),
                'activa' => $request->getPost('activa') ? 1 : 0
            ];

            $categoriaId = $this->categoriaModel->insert($categoriaData);

            if ($categoriaId) {
                return $this->sendJsonResponse(true, 'Categoría creada exitosamente', [
                    'categoria_id' => $categoriaId
                ]);
            } else {
                return $this->sendJsonResponse(false, 'Error al crear la categoría');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al crear categoría');
        }
    }
    public function getCategoria($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $categoria = $this->categoriaModel->find($id);

            if (!$categoria) {
                return $this->sendJsonResponse(false, 'Categoría no encontrada');
            }

            return $this->sendJsonResponse(true, 'Categoría obtenida exitosamente', $categoria);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener categoría');
        }
    }
    public function actualizarCategoria($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $categoria = $this->categoriaModel->find($id);
            if (!$categoria) {
                return $this->sendJsonResponse(false, 'Categoría no encontrada');
            }

            // Obtener datos JSON para PUT request, o POST como fallback
            $request = $this->request ?? service('request');
            $input = $request->getJSON(true);
            if (!$input) {
                $input = $request->getPost();
            }

            $rules = [
                'nombre' => "required|min_length[3]|max_length[100]|is_unique[categorias.nombre,id,{$id}]"
            ];

            // Usar el servicio de validation directamente
            $validation = service('validation');
            if (!$validation->setRules($rules)->run($input)) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $validation->getErrors()
                ]);
            }

            $updateData = [
                'nombre' => trim($input['nombre']),
                'descripcion' => trim($input['descripcion'] ?? ''),
                'activa' => isset($input['activa']) && $input['activa'] ? 1 : 0
            ];

            $success = $this->categoriaModel->update($id, $updateData);

            if ($success) {
                return $this->sendJsonResponse(true, 'Categoría actualizada exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al actualizar la categoría');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al actualizar categoría');
        }
    }

    public function eliminarCategoria($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $categoria = $this->categoriaModel->find($id);
            if (!$categoria) {
                return $this->sendJsonResponse(false, 'Categoría no encontrada');
            }

            // Verificar si hay productos asociados a esta categoría
            $productosAsociados = $this->productoModel->where('categoria_id', $id)->countAllResults();
            if ($productosAsociados > 0) {
                return $this->sendJsonResponse(false, 'No se puede eliminar la categoría porque tiene productos asociados');
            }
            $success = $this->categoriaModel->delete($id);

            if ($success) {
                return $this->sendJsonResponse(true, 'Categoría eliminada exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al eliminar la categoría');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al eliminar categoría');
        }
    }
    /**
     * Toggle estado activo/inactivo de la categoría
     */
    public function toggleActiva($id)
    {
        try {
            $categoria = $this->categoriaModel->find($id);
            if (!$categoria) {
                return $this->sendJsonResponse(false, 'Categoría no encontrada');
            }

            // Cambiar el estado
            $nuevoEstado = $categoria['activa'] == 1 ? 0 : 1;
            $success = $this->categoriaModel->update($id, ['activa' => $nuevoEstado]);

            if ($success) {
                $mensaje = $nuevoEstado == 1 ? 'Categoría activada exitosamente' : 'Categoría desactivada exitosamente';
                return $this->sendJsonResponse(true, $mensaje, [
                    'nuevo_estado' => $nuevoEstado,
                    'texto_estado' => $nuevoEstado == 1 ? 'Activa' : 'Inactiva'
                ]);
            } else {
                return $this->sendJsonResponse(false, 'Error al cambiar el estado de la categoría');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en toggleActiva: ' . $e->getMessage());
            return $this->handleException($e, 'Error al cambiar estado de la categoría');
        }
    }
}
