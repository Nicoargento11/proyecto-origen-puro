# Sistema de Gestión de Café - CodeIgniter 4

## Descripción del Proyecto

Sistema completo de gestión para una tienda de café desarrollado con CodeIgniter 4. Incluye gestión de productos, categorías, usuarios, carrito de compras y panel de administración.

## Características Principales

### Frontend
- 🏠 **Página principal** con presentación de productos destacados
- 🛒 **Carrito de compras** con gestión de productos
- 👤 **Sistema de autenticación** (registro/login)
- 📱 **Diseño responsive** con Bootstrap 5
- ☕ **Catálogo de productos** con filtros por categoría

### Panel de Administración
- 📊 **Dashboard** con estadísticas del negocio
- 👥 **Gestión de usuarios** con roles y permisos
- ☕ **Gestión de productos** con imágenes y categorías
- 📂 **Gestión de categorías** 
- 📦 **Gestión de pedidos** con estados
- 🔄 **APIs REST** para todas las operaciones CRUD

## Tecnologías Utilizadas

- **Backend**: CodeIgniter 4.6.0
- **Frontend**: HTML5, CSS3, JavaScript (ES6), Bootstrap 5
- **Base de Datos**: MySQL
- **Iconos**: Font Awesome 6
- **Servidor Web**: Apache (XAMPP)

## Estructura del Proyecto

```
app/
├── Controllers/
│   ├── Admin/              # Controladores del panel de administración
│   │   ├── CategoriasController.php
│   │   ├── ProductosController.php
│   │   ├── UsuariosController.php
│   │   └── PedidosController.php
│   ├── Auth.php            # Autenticación y registro
│   ├── Carrito.php         # Gestión del carrito
│   ├── Checkout.php        # Proceso de compra
│   └── Home.php            # Páginas públicas
├── Models/                 # Modelos de datos
├── Views/                  # Vistas del frontend y admin
├── Filters/                # Filtros de autenticación
└── Traits/                 # Traits auxiliares
```

## Instalación

1. **Clonar el repositorio**
```bash
git clone [URL_DEL_REPOSITORIO]
cd prueba-codeigniter
```

2. **Configurar la base de datos**
```bash
# Crear base de datos MySQL
CREATE DATABASE tienda_cafe;
```

3. **Configurar archivo .env**
```bash
cp .env.example .env
# Editar .env con tus credenciales de base de datos
```

4. **Inicializar la base de datos**
```bash
# Visitar: http://localhost/pruebacodeneigter/init-db
# Esto creará las tablas y datos iniciales
```

## Usuario Administrador
Después de ejecutar `/init-db`, se crea un usuario administrador:
- **Email**: admin@ejemplo.com
- **Contraseña**: admin123

## Licencia

Este proyecto está bajo la Licencia MIT.
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
