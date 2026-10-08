<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$id_usuario = $_SESSION['user_id'];
$producto = $data['product_name'] ?? '';
$talla = $data['size'] ?? 'Única';
$precio = floatval($data['price']);
$id_producto = intval($data['product_id']);

try {
    $stmt = $pdo->prepare("INSERT INTO RopaSeleccionada (id_usuario, producto, talla, precio, id_producto) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $producto, $talla, $precio, $id_producto]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
