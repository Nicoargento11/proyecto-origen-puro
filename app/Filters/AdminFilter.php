<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Si no está logueado, redirigir al login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder');
        }

        // Verificar si tiene rol de admin
        $rol = $session->get('rol');
        $roles = $session->get('roles');

        $esAdmin = false;

        // Verificar por rol principal
        if ($rol === 'admin') {
            $esAdmin = true;
        }

        // Verificar en la lista de roles
        if (!$esAdmin && $roles) {
            foreach ($roles as $rolItem) {
                if (isset($rolItem['nombre']) && $rolItem['nombre'] === 'admin') {
                    $esAdmin = true;
                    break;
                }
            }
        }

        // Si no es admin, denegar acceso
        if (!$esAdmin) {
            return redirect()->to('/perfil')->with('error', 'No tienes permisos para acceder a esta área');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos hacer nada después
    }
}
