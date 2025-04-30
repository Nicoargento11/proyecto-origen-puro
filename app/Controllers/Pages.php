<?php

namespace App\Controllers;

// Add this line to import the class.
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // No se encontró la página
            throw new PageNotFoundException($page);
        }

        $data['title'] = 'Tienda de Café - ' . ucfirst($page);

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
}
