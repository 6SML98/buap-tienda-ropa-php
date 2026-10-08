<?php
require '../includes/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM Productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos en Stock</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Productos en Stock</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Tallas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                        <td>
                            <img src="../assets/img/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" width="100">
                        </td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                        <td>$<?= htmlspecialchars($producto['precio']) ?></td>
                        <td><?= htmlspecialchars($producto['stock']) ?></td>
                        <td><?= htmlspecialchars($producto['tallas']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="admin.html" class="continue-shopping">Volver al Panel de Administrador</a>
    </main>
</body>
</html>
