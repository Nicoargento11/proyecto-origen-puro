<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Traits\AdminHelpers;

class UsuariosController extends BaseController
{
    use AdminHelpers;

    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // =============================================
    // VISTAS
    // =============================================

    public function index()
    {
        $data = [
            'title' => 'Gestión de Usuarios',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/usuarios/index', $data);
    }

    public function crear()
    {
        $data = [
            'title' => 'Crear Usuario',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/usuarios/crear', $data);
    }

    public function editar($id)
    {
        $usuario = $this->usuarioModel->getUsuarioConRoles($id);
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado');
        }

        $data = [
            'title' => 'Editar Usuario',
            'user' => $this->getAdminUserData(),
            'usuario' => $usuario
        ];

        return view('admin/usuarios/editar', $data);
    }

    public function ver($id)
    {
        $usuario = $this->usuarioModel->getUsuarioConRoles($id);
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado');
        }

        $data = [
            'title' => 'Ver Usuario',
            'user' => $this->getAdminUserData(),
            'usuario' => $usuario
        ];

        return view('admin/usuarios/ver', $data);
    }

    // =============================================
    // APIs
    // =============================================

    public function getUsuarios()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $usuarios = $this->usuarioModel->select('usuarios.*, GROUP_CONCAT(roles.nombre) as roles_nombres')
                ->join('usuario_roles', 'usuario_roles.usuario_id = usuarios.id', 'left')
                ->join('roles', 'roles.id = usuario_roles.rol_id', 'left')
                ->groupBy('usuarios.id')
                ->orderBy('usuarios.fecha_registro', 'DESC')
                ->findAll();

            // Procesar roles para cada usuario
            foreach ($usuarios as &$usuario) {
                $usuario['roles'] = [];
                if ($usuario['roles_nombres']) {
                    $rolesNombres = explode(',', $usuario['roles_nombres']);
                    foreach ($rolesNombres as $rolNombre) {
                        $usuario['roles'][] = ['nombre' => trim($rolNombre)];
                    }
                }
                unset($usuario['roles_nombres']);
            }

            return $this->sendJsonResponse(true, 'Usuarios obtenidos exitosamente', $usuarios);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener usuarios');
        }
    }
    public function crearUsuario()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;
        try {
            // Obtener datos del request de forma simple
            $request = service('request');
            $input = $request->getBody();
            $requestData = json_decode($input, true);
            if (!$requestData) {
                $requestData = $request->getPost();
            }

            if (empty($requestData)) {
                return $this->sendJsonResponse(false, 'No se recibieron datos');
            }
            $rules = [
                'nombre' => 'required|min_length[2]|max_length[50]',
                'apellido' => 'required|min_length[2]|max_length[50]',
                'email' => 'required|valid_email|is_unique[usuarios.email]',
                'password' => 'required|min_length[6]',
                'rol' => 'required'
            ];

            $validation = service('validation');
            $validation->setRules($rules);

            if (!$validation->run($requestData)) {
                return $this->sendJsonResponse(false, 'Datos de validación incorrectos', [
                    'errors' => $validation->getErrors()
                ]);
            }
            $userData = [
                'nombre' => $requestData['nombre'],
                'apellido' => $requestData['apellido'],
                'email' => $requestData['email'],
                'password' => password_hash($requestData['password'], PASSWORD_DEFAULT),
                'telefono' => $requestData['telefono'] ?? '',
                'direccion' => $requestData['direccion'] ?? '',
                'ciudad' => $requestData['ciudad'] ?? '',
                'codigo_postal' => $requestData['codigo_postal'] ?? '',
                'pais' => $requestData['pais'] ?? 'Argentina'
            ];
            $userId = $this->usuarioModel->insert($userData);

            if ($userId) {
                // Asignar rol
                $rolId = $requestData['rol'];
                $this->usuarioModel->asignarRol($userId, $rolId);

                return $this->sendJsonResponse(true, 'Usuario creado exitosamente', [
                    'usuario_id' => $userId
                ]);
            } else {
                return $this->sendJsonResponse(false, 'Error al crear el usuario');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al crear usuario');
        }
    }

    public function getUsuario($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $usuario = $this->usuarioModel->getUsuarioConRoles($id);

            if (!$usuario) {
                return $this->sendJsonResponse(false, 'Usuario no encontrado');
            }
            return $this->sendJsonResponse(true, 'Usuario obtenido exitosamente', $usuario);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener usuario');
        }
    }
    public function actualizarUsuario($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->sendJsonResponse(false, 'Usuario no encontrado');
            }

            $request = service('request');
            $input = $request->getBody();
            $requestData = json_decode($input, true);

            if (!$requestData) {
                $requestData = $request->getPost();
            }

            $rules = [
                'nombre' => 'required|min_length[2]|max_length[50]',
                'apellido' => 'required|min_length[2]|max_length[50]',
                'email' => "required|valid_email|is_unique[usuarios.email,id,{$id}]"
            ];

            if (!empty($requestData['password'])) {
                $rules['password'] = 'min_length[6]';
            }

            $validation = service('validation');
            if (!$validation->setRules($rules)->run($requestData)) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $validation->getErrors()
                ]);
            }
            $updateData = [
                'nombre' => $requestData['nombre'],
                'apellido' => $requestData['apellido'],
                'email' => $requestData['email'],
                'telefono' => $requestData['telefono'] ?? '',
                'direccion' => $requestData['direccion'] ?? '',
                'ciudad' => $requestData['ciudad'] ?? '',
                'codigo_postal' => $requestData['codigo_postal'] ?? '',
                'pais' => $requestData['pais'] ?? 'Argentina'
            ];

            if (!empty($requestData['password'])) {
                $updateData['password'] = password_hash($requestData['password'], PASSWORD_DEFAULT);
            }

            $success = $this->usuarioModel->update($id, $updateData);

            if ($success) {
                if (isset($requestData['rol'])) {
                    $this->usuarioModel->eliminarRoles($id);
                    $this->usuarioModel->asignarRol($id, $requestData['rol']);
                }

                return $this->sendJsonResponse(true, 'Usuario actualizado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al actualizar el usuario');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al actualizar usuario');
        }
    }

    public function eliminarUsuario($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->sendJsonResponse(false, 'Usuario no encontrado');
            }

            // No permitir eliminar el usuario actual
            $session = session();
            if ($id == $session->get('id')) {
                return $this->sendJsonResponse(false, 'No puedes eliminar tu propio usuario');
            }

            $success = $this->usuarioModel->delete($id);

            if ($success) {
                return $this->sendJsonResponse(true, 'Usuario eliminado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al eliminar el usuario');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al eliminar usuario');
        }
    }
    public function getRoles()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $rolModel = new \App\Models\RolModel();
            $roles = $rolModel->getAllRoles();
            return $this->sendJsonResponse(true, 'Roles obtenidos exitosamente', $roles);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener roles');
        }
    }
    // Cambiar estado de baja/activo de un usuario (AJAX)
    public function cambiarEstadoBajaUsuario($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->sendJsonResponse(false, 'Usuario no encontrado');
            }

            $request = service('request');
            $input = $request->getBody();
            $requestData = json_decode($input, true);
            if (!$requestData) {
                $requestData = $request->getPost();
            }
            $nuevoEstado = isset($requestData['baja']) && $requestData['baja'] === 'SI' ? 'SI' : 'NO';

            // No permitir darse de baja a sí mismo
            $session = session();
            if ($id == $session->get('id')) {
                return $this->sendJsonResponse(false, 'No puedes darte de baja a ti mismo');
            }

            $this->usuarioModel->update($id, ['baja' => $nuevoEstado]);
            $mensaje = $nuevoEstado === 'SI' ? 'Usuario dado de baja correctamente' : 'Usuario reactivado correctamente';
            return $this->sendJsonResponse(true, $mensaje);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al cambiar el estado del usuario');
        }
    }
}
