<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $imagen = htmlspecialchars(trim($_POST['imagen']));
    $tallas = htmlspecialchars(trim($_POST['tallas']));
    $tipo = intval($_POST['tipo']);

    try {
        $stmt = $pdo->prepare("INSERT INTO Productos (nombre, descripcion, precio, stock, imagen, tallas, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen, $tallas, $tipo]);
        echo "<script>alert('Producto añadido exitosamente'); window.location.href='admin.html';</script>";
    } catch (PDOException $e) {
        die("Error al añadir producto: " . $e->getMessage());
    }
}

// Mostrar productos existentes (opcional)
$stmt = $pdo->query("SELECT * FROM Productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Este formulario puede estar en una página HTML o aquí mismo -->
<form method="POST" action="add_product.php">
  <label for="nombre">Nombre:</label>
  <input type="text" name="nombre" required>

  <label for="descripcion">Descripción:</label>
  <textarea name="descripcion" required></textarea>

  <label for="precio">Precio:</label>
  <input type="number" step="0.01" name="precio" required>

  <label for="stock">Stock:</label>
  <input type="number" name="stock" required>

  <label for="imagen">Nombre de imagen:</label>
  <input type="text" name="imagen" placeholder="Ej: Playera1.png" required>

  <label for="tallas">Tallas (separadas por coma):</label>
  <input type="text" name="tallas" placeholder="Ej: S,M,L,XL" required>

  <label for="tipo">Tipo de Producto:</label>
  <select id="tipo" name="tipo" required>
      <option value="0">Playeras</option>
      <option value="1">Pantalones</option>
      <option value="2">Accesorios</option>
  </select>

  <button type="submit">Agregar Producto</button>
</form>

<a href="admin.html">Volver al Panel de Administrador</a>
