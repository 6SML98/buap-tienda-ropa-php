<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_NUMBER_INT);
    $nuevo_nombre = htmlspecialchars(trim($_POST['nuevo_nombre'] ?? ''));
    $nueva_descripcion = htmlspecialchars(trim($_POST['nueva_descripcion'] ?? ''));
    $nuevo_precio = $_POST['nuevo_precio'] !== '' ? floatval($_POST['nuevo_precio']) : null;
    $nuevo_stock = $_POST['nuevo_stock'] !== '' ? intval($_POST['nuevo_stock']) : null;

    try {
        $query = "UPDATE Productos SET ";
        $params = [];

        if ($nuevo_nombre !== '') {
            $query .= "nombre = ?, ";
            $params[] = $nuevo_nombre;
        }
        if ($nueva_descripcion !== '') {
            $query .= "descripcion = ?, ";
            $params[] = $nueva_descripcion;
        }
        if (!is_null($nuevo_precio)) {
            $query .= "precio = ?, ";
            $params[] = $nuevo_precio;
        }
        if (!is_null($nuevo_stock)) {
            $query .= "stock = ?, ";
            $params[] = $nuevo_stock;
        }

        // Si no se modificó ningún campo, evitar consulta inválida
        if (empty($params)) {
            echo "<script>alert('No se proporcionó ningún campo para modificar'); window.location.href='admin.html';</script>";
            exit;
        }

        $query = rtrim($query, ", ") . " WHERE id_producto = ?";
        $params[] = $id_producto;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        echo "<script>alert('Producto modificado exitosamente'); window.location.href='admin.html';</script>";
    } catch (PDOException $e) {
        die("Error al modificar producto: " . $e->getMessage());
    }
}
?>
