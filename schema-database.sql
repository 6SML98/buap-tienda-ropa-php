-- Esquema estructural de ejemplo. No incluye los registros originales.

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    fecha_nacimiento DATE,
    tipo INT NOT NULL -- 0: Cliente, 1: Administrador
);

CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY, 
    imagen VARCHAR(255) NOT NULL,              
    nombre VARCHAR(255) NOT NULL,             
    descripcion TEXT NOT NULL,                 
    precio DECIMAL(10, 2) NOT NULL,            
    tallas VARCHAR(50) DEFAULT 'N',            
    tipo INT NOT NULL,                         
    stock INT NOT NULL                         
);

CREATE TABLE RopaSeleccionada (
    id_seleccion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    producto VARCHAR(100) NOT NULL,
    talla VARCHAR(5) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    fecha_seleccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_producto INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto)
);

CREATE TABLE Ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE DetalleVenta (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    producto_nombre VARCHAR(100) NOT NULL,
    talla VARCHAR(5) NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto)
);
