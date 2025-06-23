<?php

namespace App\Controllers;

use App\Models\RolModel;
use App\Models\UsuarioModel;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;

class InitDB extends BaseController
{
    public function init()
    {
        try {
            $rolModel = new RolModel();
            $usuarioModel = new UsuarioModel();

            echo "<h2>Inicializando Base de Datos...</h2>";

            // 1. Crear roles básicos
            echo "<h3>1. Creando roles básicos...</h3>";
            $rolModel->crearRolesBasicos();
            echo "✅ Roles creados correctamente<br>";

            // 2. Obtener IDs de roles
            $rolAdmin = $rolModel->getRolPorNombre('admin');
            $rolUsuario = $rolModel->getRolPorNombre('usuario');

            // 3. Crear usuario admin por defecto (si no existe)
            echo "<h3>2. Verificando usuario admin...</h3>";
            $adminEmail = 'admin@origenepuro.com';
            $adminExistente = $usuarioModel->where('email', $adminEmail)->first();

            if (!$adminExistente) {
                $adminData = [
                    'nombre' => 'Administrador',
                    'apellido' => 'Sistema',
                    'email' => $adminEmail,
                    'password' => 'admin123', // Se hasheará automáticamente
                    'telefono' => '123-456-7890',
                    'ciudad' => 'Buenos Aires',
                    'pais' => 'Argentina'
                ];

                $adminId = $usuarioModel->insert($adminData);
                if ($adminId) {
                    // Asignar rol de admin
                    $usuarioModel->asignarRol($adminId, $rolAdmin['id']);
                    echo "✅ Usuario admin creado: $adminEmail / admin123<br>";
                } else {
                    echo "❌ Error al crear usuario admin<br>";
                }
            } else {
                echo "ℹ️ Usuario admin ya existe<br>";
                // Asegurar que tenga el rol admin
                $usuarioModel->asignarRol($adminExistente['id'], $rolAdmin['id']);
            }
            echo "<h3>3. Resumen de roles:</h3>";
            $roles = $rolModel->findAll();
            foreach ($roles as $rol) {
                echo "- {$rol['nombre']}: {$rol['descripcion']}<br>";
            }

            // 4. Crear categorías de productos
            echo "<h3>4. Creando categorías de productos...</h3>";
            $this->crearCategorias();

            // 5. Crear productos de muestra
            echo "<h3>5. Creando productos de muestra...</h3>";
            $this->crearProductos();

            echo "<h3>✅ Inicialización completada!</h3>";
            echo "<p><a href='" . base_url('login') . "'>Ir al Login</a> | <a href='" . base_url('productos') . "'>Ver Productos</a></p>";
        } catch (\Exception $e) {
            echo "<h3>❌ Error en la inicialización:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
        }
    }

    private function crearCategorias()
    {
        $categoriaModel = new CategoriaModel();

        $categorias = [
            [
                'nombre' => 'Café Gourmet',
                'descripcion' => 'Cafés premium de alta calidad, seleccionados de las mejores fincas',
                'slug' => 'cafe-gourmet',
                'activa' => true
            ],
            [
                'nombre' => 'Café Orgánico',
                'descripcion' => 'Cafés certificados orgánicos, cultivados sin químicos',
                'slug' => 'cafe-organico',
                'activa' => true
            ],
            [
                'nombre' => 'Café de Origen',
                'descripcion' => 'Cafés de origen único, con características distintivas de su región',
                'slug' => 'cafe-de-origen',
                'activa' => true
            ],
            [
                'nombre' => 'Blends Especiales',
                'descripcion' => 'Mezclas únicas creadas por nuestros maestros tostadores',
                'slug' => 'blends-especiales',
                'activa' => true
            ]
        ];

        foreach ($categorias as $categoria) {
            $existente = $categoriaModel->where('slug', $categoria['slug'])->first();
            if (!$existente) {
                $categoriaModel->insert($categoria);
                echo "✅ Categoría creada: {$categoria['nombre']}<br>";
            } else {
                echo "ℹ️ Categoría ya existe: {$categoria['nombre']}<br>";
            }
        }
    }

    private function crearProductos()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Obtener IDs de categorías
        $gourmet = $categoriaModel->where('slug', 'cafe-gourmet')->first();
        $organico = $categoriaModel->where('slug', 'cafe-organico')->first();
        $origen = $categoriaModel->where('slug', 'cafe-de-origen')->first();
        $blends = $categoriaModel->where('slug', 'blends-especiales')->first();

        $productos = [
            [
                'nombre' => 'Café Colombia Supremo',
                'descripcion' => 'Un café excepcional de las tierras altas de Colombia, con notas a chocolate y caramelo.',
                'precio' => 2850.00,
                'stock' => 50,
                'categoria_id' => $gourmet['id'],
                'origen' => 'Colombia',
                'proceso' => 'Lavado',
                'tostacion' => 'Medio',
                'notas_cata' => 'Chocolate, caramelo, nueces, acidez media',
                'puntuacion' => 4.5,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Café Etiopía Yirgacheffe',
                'descripcion' => 'Café de origen etíope con perfil floral y cítrico único.',
                'precio' => 3200.00,
                'stock' => 30,
                'categoria_id' => $origen['id'],
                'origen' => 'Etiopía',
                'proceso' => 'Natural',
                'tostacion' => 'Claro',
                'notas_cata' => 'Floral, cítrico, té, acidez brillante',
                'puntuacion' => 4.8,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Café Orgánico Guatemala',
                'descripcion' => 'Café orgánico certificado de las montañas de Guatemala.',
                'precio' => 2950.00,
                'stock' => 40,
                'categoria_id' => $organico['id'],
                'origen' => 'Guatemala',
                'proceso' => 'Lavado',
                'tostacion' => 'Medio',
                'notas_cata' => 'Chocolate oscuro, especias, cuerpo completo',
                'puntuacion' => 4.3,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Blend Origen Puro Signature',
                'descripcion' => 'Nuestra mezcla exclusiva que combina granos de Brasil y Colombia.',
                'precio' => 2650.00,
                'stock' => 60,
                'categoria_id' => $blends['id'],
                'origen' => 'Brasil & Colombia',
                'proceso' => 'Mixto',
                'tostacion' => 'Medio-Oscuro',
                'notas_cata' => 'Equilibrado, chocolate, caramelo, cuerpo medio',
                'puntuacion' => 4.4,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Café Brasil Santos',
                'descripcion' => 'Clásico café brasileño con sabor suave y equilibrado.',
                'precio' => 2400.00,
                'stock' => 45,
                'categoria_id' => $gourmet['id'],
                'origen' => 'Brasil',
                'proceso' => 'Natural',
                'tostacion' => 'Medio',
                'notas_cata' => 'Nueces, chocolate con leche, dulce',
                'puntuacion' => 4.1,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Café Costa Rica Tarrazú',
                'descripcion' => 'Café de altura de Costa Rica con excelente acidez y aroma.',
                'precio' => 3100.00,
                'stock' => 25,
                'categoria_id' => $origen['id'],
                'origen' => 'Costa Rica',
                'proceso' => 'Lavado',
                'tostacion' => 'Medio',
                'notas_cata' => 'Cítrico, miel, acidez brillante, cuerpo medio',
                'puntuacion' => 4.6,
                'destacado' => false,
                'activo' => true
            ]
        ];

        foreach ($productos as $producto) {
            $existente = $productoModel->where('nombre', $producto['nombre'])->first();
            if (!$existente) {
                $productoModel->insert($producto);
                echo "✅ Producto creado: {$producto['nombre']}<br>";
            } else {
                echo "ℹ️ Producto ya existe: {$producto['nombre']}<br>";
            }
        }
    }
}
