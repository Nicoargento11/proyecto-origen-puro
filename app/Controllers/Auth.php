<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }    // Mostrar formulario de registro
    public function registro()
    {
        // Si ya está logueado, redirigir al perfil
        if ($this->session->get('logged_in')) {
            return redirect()->to('/perfil');
        }

        $data = [
            'title' => 'Registro de Usuario'
        ];
        return view('auth/registro', $data);
    }    // Procesar el registro
    public function procesarRegistro()
    {
        // Validación
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[30]',
            'apellido' => 'required|min_length[2]|max_length[30]',
            'email' => 'required|valid_email|max_length[50]|is_unique[usuarios.email]',
            'password' => 'required|min_length[6]|max_length[50]',
            'confirmar_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        try {
            $model = new UsuarioModel();

            $userData = [
                'nombre' => esc($this->request->getPost('nombre')),
                'apellido' => esc($this->request->getPost('apellido')),
                'email' => esc($this->request->getPost('email')),
                'usuario' => esc($this->request->getPost('email')), // Usar email como usuario
                'password' => $this->request->getPost('password'),
                'rol' => 'usuario',
                'baja' => 'NO' // Usuario activo por defecto
            ];

            // Usar save() en lugar de insert() para mejor manejo
            $saveResult = $model->save($userData);

            // Con save(), verificamos si hay errores del modelo
            if ($saveResult === false && !empty($model->errors())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $model->errors());
            }

            return redirect()->to('/login')
                ->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['general' => 'Error al procesar el registro: ' . $e->getMessage()]);
        }
    }    // Mostrar formulario de login
    public function login()
    {
        // Si ya está logueado, redirigir al perfil
        if ($this->session->get('logged_in')) {
            return redirect()->to('/perfil');
        }

        $data = [
            'title' => 'Iniciar Sesión'
        ];
        return view('auth/login', $data);
    }

    // Procesar el login
    public function procesarLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        try {
            $model = new UsuarioModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $model->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Email o contraseña incorrectos');
            }

            // Verificar contraseña
            if (!password_verify($password, $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Email o contraseña incorrectos');
            }

            // Obtener usuario con roles
            $userConRoles = $model->getUsuarioConRoles($user['id']);

            // Determinar rol principal (el primero o 'usuario' por defecto)
            $rolPrincipal = 'usuario';
            if (!empty($userConRoles['roles'])) {
                $rolPrincipal = $userConRoles['roles'][0]['nombre'];
            }

            // Crear sesión
            $sessionData = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'email' => $user['email'],
                'telefono' => $user['telefono'] ?? '',
                'direccion' => $user['direccion'] ?? '',
                'ciudad' => $user['ciudad'] ?? '',
                'codigo_postal' => $user['codigo_postal'] ?? '',
                'pais' => $user['pais'] ?? '',
                'rol' => $rolPrincipal,
                'roles' => $userConRoles['roles'] ?? [],
                'logged_in' => true
            ];
            $this->session->set($sessionData);            // Redirigir según rol
            if ($model->tieneRol($user['id'], 'admin')) {
                return redirect()->to('/admin')
                    ->with('success', '¡Bienvenido Admin!');
            }

            return redirect()->to('/perfil')
                ->with('success', '¡Bienvenido ' . $user['nombre'] . '!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar el login: ' . $e->getMessage());
        }
    }

    // Cerrar sesión
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')
            ->with('success', 'Sesión cerrada correctamente');
    }

    // Dashboard de usuario
    public function dashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para acceder');
        }

        // Obtener estadísticas básicas para el dashboard
        $usuarioModel = new \App\Models\UsuarioModel();
        $productoModel = new \App\Models\ProductoModel();

        $stats = [
            'usuarios' => $usuarioModel->countAll(),
            'productos' => $productoModel->where('activo', true)->countAllResults(),
            'pedidos' => 0, // Placeholder hasta implementar sistema de pedidos
            'ventas' => 0   // Placeholder hasta implementar sistema de ventas
        ];

        $data = [
            'title' => 'Perfil - ' . $this->session->get('nombre'),
            'user' => [
                'id' => $this->session->get('id'),
                'nombre' => $this->session->get('nombre'),
                'apellido' => $this->session->get('apellido'),
                'email' => $this->session->get('email'),
                'rol' => $this->session->get('rol')
            ],
            'stats' => $stats
        ];

        return view('admin/dashboard', $data);
    }    // Dashboard de admin
    public function adminDashboard()
    {
        if (!$this->session->get('logged_in') || $this->session->get('rol') !== 'admin') {
            return redirect()->to('/login')
                ->with('error', 'Acceso denegado');
        }

        // Obtener estadísticas para el dashboard
        $usuarioModel = new \App\Models\UsuarioModel();
        $productoModel = new \App\Models\ProductoModel();

        $stats = [
            'usuarios' => $usuarioModel->countAll(),
            'productos' => $productoModel->where('activo', true)->countAllResults(),
            'pedidos' => 0, // Placeholder hasta implementar sistema de pedidos
            'ventas' => 0   // Placeholder hasta implementar sistema de ventas
        ];

        $data = [
            'title' => 'Admin Dashboard - ' . $this->session->get('nombre'),
            'user' => [
                'id' => $this->session->get('id'),
                'nombre' => $this->session->get('nombre'),
                'apellido' => $this->session->get('apellido'),
                'email' => $this->session->get('email'),
                'rol' => $this->session->get('rol')
            ],
            'stats' => $stats
        ];

        return view('templates/header')
            . view('admin/dashboard', $data)
            . view('templates/footer');
    } // Mostrar perfil del usuario
    public function perfil()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para acceder');
        }

        $model = new UsuarioModel();
        $userData = $model->getUsuarioConRoles($this->session->get('id'));
        $data = [
            'title' => 'Mi Perfil - ' . $this->session->get('nombre'),
            'user' => $userData
        ];
        return view('auth/ver_perfil', $data);
    }

    // Mostrar formulario de edición del perfil
    public function perfilEditar()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para acceder');
        }

        $model = new UsuarioModel();
        $userData = $model->getUsuarioConRoles($this->session->get('id'));

        $data = [
            'title' => 'Editar Perfil - ' . $this->session->get('nombre'),
            'user' => $userData
        ];
        return view('auth/perfil', $data);
    }

    // Dashboard del usuario (pedidos, historial, etc.)
    public function perfilDashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para acceder');
        }

        $model = new UsuarioModel();
        $userData = $model->getUsuarioConRoles($this->session->get('id'));

        $data = [
            'title' => 'Mi Dashboard - ' . $this->session->get('nombre'),
            'user' => $userData
        ];

        return view('auth/dashboard', $data);
    }

    // Actualizar perfil del usuario
    public function actualizarPerfil()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[30]',
            'apellido' => 'required|min_length[2]|max_length[30]',
            'email' => 'required|valid_email|max_length[50]',
            'usuario' => 'required|min_length[3]|max_length[20]'
        ];

        // Si se proporciona nueva contraseña, agregar validaciones
        if ($this->request->getPost('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min_length[6]|max_length[50]';
            $rules['confirm_password'] = 'required|matches[new_password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            $model = new UsuarioModel();
            $userId = $this->session->get('id');
            $currentUser = $model->find($userId);

            // Verificar contraseña actual si se quiere cambiar
            if ($this->request->getPost('new_password')) {
                $currentPassword = $this->request->getPost('current_password');
                if (!password_verify($currentPassword, $currentUser['password'])) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'La contraseña actual es incorrecta');
                }
            }

            $updateData = [
                'nombre' => esc($this->request->getPost('nombre')),
                'apellido' => esc($this->request->getPost('apellido')),
                'email' => esc($this->request->getPost('email')),
                'usuario' => esc($this->request->getPost('usuario'))
            ];

            // Agregar nueva contraseña si se proporcionó
            if ($this->request->getPost('new_password')) {
                $updateData['password'] = $this->request->getPost('new_password');
            }

            $updateResult = $model->update($userId, $updateData);

            if ($updateResult === false && !empty($model->errors())) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $model->errors());
            }

            // Actualizar datos de sesión
            $this->session->set([
                'nombre' => $updateData['nombre'],
                'apellido' => $updateData['apellido'],
                'email' => $updateData['email']
            ]);

            return redirect()->to('/perfil')
                ->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }

    // Verificar si el usuario está logueado (helper method)
    public function isLoggedIn(): bool
    {
        return $this->session->get('logged_in') === true;
    }

    // Verificar si el usuario es admin (helper method)
    public function isAdmin(): bool
    {
        return $this->isLoggedIn() && $this->session->get('rol') === 'admin';
    }
}
