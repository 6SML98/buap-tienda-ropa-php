# Tienda de ropa

Tienda escolar con registro, inicio de sesión, catálogo por categoría, carrito y administración de productos.

## Requisitos

PHP 8 con PDO MySQL y MySQL/MariaDB.

## Ejecutar

1. Crea una base vacía e importa schema-database.sql.
2. Define DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASSWORD en el entorno. DB_NAME usa DEAPPSWEB por defecto.
3. Inicia `php -S 127.0.0.1:8000` desde esta carpeta y abre http://127.0.0.1:8000/index.html.

El registro público crea clientes. Para una cuenta administradora de pruebas, cambia su campo tipo a 1 directamente en tu base local; no publiques contraseñas.

## Verificación del 8 de octubre de 2026

Probado con PHP 8.0.18 y MariaDB 10.4.24 en una base aislada: registro, login, carrito, vaciado y alta/edición/baja de productos. Se comprobó rechazo de clientes en operaciones administrativas y uso del precio de la BD. checkout.php vacía el carrito: no cobra pagos, registra una venta ni descuenta existencias. Requiere completar ese flujo para una tienda real.
