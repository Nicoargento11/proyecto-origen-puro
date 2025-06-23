<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Obtener productos destacados para mostrar en la home
        $productoModel = new \App\Models\ProductoModel();
        $productos = $productoModel->obtenerProductosDestacados(4);

        $data = [
            'productos_destacados' => $productos
        ];

        return view('templates/header')
            . view('principal', $data)
            . view('templates/footer');
    }


    public function about(): string
    {
        $data = [
            'title' => 'Sobre Nosotros | Tienda de Café',
            'team' => [
                ['name' => 'Nicolas Valdes', 'role' => 'Fundador', 'bio' => 'Apasionado por el café de especialidad.'],
                ['name' => 'Luciano Villordo', 'role' => 'Fundador', 'bio' => 'Experta en métodos de extracción.']
            ]
        ];
        return view("about.php", $data);
    }

    public function contacto(): string
    {
        return view("contacto.php");
    }

    public function comercializacion(): string
    {
        $data = [
            'title' => 'Comercialización | Tienda de Café'
        ];
        return view("comercializacion.php", $data);
    }

    public function enviarContacto()
    {
        $validation = \Config\Services::validation();

        // Reglas de validación
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'asunto' => 'required|in_list[consulta,reserva,evento,productos,otros]',
            'mensaje' => 'required|min_length[3]|max_length[1000]'
        ];

        // Mensajes personalizados
        $messages = [
            'nombre' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 50 caracteres'
            ],
            // ... (otros mensajes personalizados)
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->to(base_url('contacto'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Simulación de envío exitoso
        $simulacionExitosa = true; // Cambiar a false para simular un error

        if ($simulacionExitosa) {
            session()->setFlashdata('success', [
                'message' => 'El formulario se ha enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ]);
        } else {
            session()->setFlashdata('error', [
                'title' => 'Error',
                'message' => 'Ocurrió un problema al enviar el formulario. Por favor intenta nuevamente.'
            ]);
        }

        return redirect()->to(base_url('contacto'));
    }

    public function terminos(): string
    {
        $data = [
            'siteName' => 'Café del Aroma',
            'defaultCurrency' => 'Pesos Argentinos (ARS)',
            'legalCountry' => 'Argentina',
            'legalCity' => 'Buenos Aires',
            'supportEmail' => 'info@cafedelaroma.com',
            'contactPhone' => '+54 11 1234-5678',
            'companyAddress' => 'Av. Corrientes 1234, CABA',
            'fechaActualizacion' => date('d/m/Y'),
            'terminos' => [
                [
                    'id' => 'aceptacion',
                    'titulo' => 'Aceptación de los Términos',
                    'contenido' => '<p>Al acceder y utilizar los servicios de Café del Aroma, usted acepta estar legalmente obligado por estos términos y condiciones. Si no está de acuerdo con alguno de estos términos, por favor absténgase de utilizar nuestro sitio web y servicios.</p>'
                ],
                [
                    'id' => 'productos',
                    'titulo' => 'Productos y Servicios',
                    'contenido' => '<p>2.1. Café del Aroma se especializa en la venta de café de especialidad y productos relacionados.</p>
                                    <p>2.2. Nos reservamos el derecho de modificar o descontinuar productos sin previo aviso.</p>
                                    <p>2.3. Las imágenes de los productos son ilustrativas y pueden variar ligeramente del producto final.</p>'
                ],
                [
                    'id' => 'pedidos',
                    'titulo' => 'Pedidos y Pagos',
                    'contenido' => '<p>3.1. Todos los pedidos están sujetos a disponibilidad y confirmación de precio.</p>
                                    <p>3.2. Aceptamos los siguientes métodos de pago: tarjetas de crédito/débito, transferencias bancarias, PayPal y criptomonedas seleccionadas.</p>
                                    <p>3.3. Los precios están expresados en Pesos Argentinos (ARS) e incluyen IVA cuando aplica.</p>
                                    <p>3.4. Para suscripciones: El pago será recurrente según el ciclo seleccionado hasta cancelación.</p>'
                ],
                [
                    'id' => 'envios',
                    'titulo' => 'Envíos y Entregas',
                    'contenido' => '<p>4.1. Realizamos envíos a todo el territorio nacional. Para envíos internacionales, contáctenos.</p>
                                    <p>4.2. Los tiempos de entrega son estimados y pueden variar por factores externos.</p>
                                    <p>4.3. El riesgo de pérdida o daño de los productos se transfiere al cliente una vez entregado el paquete.</p>'
                ],
                [
                    'id' => 'devoluciones',
                    'titulo' => 'Devoluciones y Reembolsos',
                    'contenido' => '<p>5.1. Aceptamos devoluciones dentro de los 7 días posteriores a la recepción, siempre que el producto esté en su estado original.</p>
                                    <p>5.2. Para productos perecederos como el café, solo aceptamos devoluciones si el producto llega en mal estado o no corresponde al pedido.</p>
                                    <p>5.3. Los reembolsos se procesarán utilizando el mismo método de pago original.</p>'
                ],
                [
                    'id' => 'propiedad',
                    'titulo' => 'Propiedad Intelectual',
                    'contenido' => '<p>6.1. Todo el contenido del sitio web (textos, gráficos, logos, imágenes) es propiedad de Café del Aroma y está protegido por leyes de propiedad intelectual.</p>
                                    <p>6.2. Queda prohibida la reproducción total o parcial sin autorización expresa.</p>'
                ],
                [
                    'id' => 'limitacion',
                    'titulo' => 'Limitación de Responsabilidad',
                    'contenido' => '<p>7.1. Café del Aroma no será responsable por daños indirectos, incidentales o consecuentes resultantes del uso de nuestros productos.</p>
                                    <p>7.2. No garantizamos que el sitio web esté libre de errores o interrupciones.</p>'
                ],
                [
                    'id' => 'privacidad',
                    'titulo' => 'Privacidad',
                    'contenido' => '<p>8.1. La información personal proporcionada está protegida según nuestra Política de Privacidad.</p>
                                    <p>8.2. Utilizamos cookies para mejorar la experiencia del usuario. Puede gestionarlas en la configuración de su navegador.</p>'
                ],
                [
                    'id' => 'modificaciones',
                    'titulo' => 'Modificaciones',
                    'contenido' => '<p>9.1. Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación.</p>
                                    <p>9.2. Es responsabilidad del usuario revisar periódicamente estos términos.</p>'
                ],
                [
                    'id' => 'jurisdiccion',
                    'titulo' => 'Jurisdicción',
                    'contenido' => '<p>10.1. Estos términos se rigen por las leyes de Argentina.</p>
                                    <p>10.2. Cualquier disputa será resuelta en los tribunales competentes de Buenos Aires.</p>'
                ]
            ]
        ];
        return view('templates/header')
            . view("terminos.php", $data)
            . view('templates/footer');
    }

    // Método de prueba para verificar que el sistema funciona
    public function testCheckout()
    {
        if (!session('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder al checkout');
        }

        $data = [
            'titulo' => 'Test del Sistema de Checkout',
            'mensaje' => 'El sistema de checkout está funcionando correctamente',
            'enlaces' => [
                'Carrito' => base_url('carrito'),
                'Checkout' => base_url('checkout'),
                'Mis Pedidos' => base_url('mis-pedidos'),
                'Inicializar Métodos de Pago' => base_url('checkout/init-metodos-pago')
            ]
        ];

        return view('templates/header')
            . view('test_checkout', $data)
            . view('templates/footer');
    }
}
