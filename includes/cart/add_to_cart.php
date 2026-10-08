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

$id_producto = intval($data['product_id'] ?? 0);
$talla = $data['size'] ?? 'Única';
$consulta = $pdo->prepare('SELECT nombre, precio, stock FROM Productos WHERE id_producto = ?');
$consulta->execute([$id_producto]);
$producto_db = $consulta->fetch(PDO::FETCH_ASSOC);
if (!$producto_db || $producto_db['stock'] < 1) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Producto no disponible']);
    exit;
}
$producto = $producto_db['nombre'];
$precio = $producto_db['precio'];

try {

    $stmt = $pdo->prepare("INSERT INTO RopaSeleccionada (id_usuario, producto, talla, precio, id_producto) VALUES (?, ?, ?, ?, ?)");

    $stmt->execute([$id_usuario, $producto, $talla, $precio, $id_producto]);



    echo json_encode(['success' => true]);

} catch (PDOException $e) {

    echo json_encode(['success' => false, 'message' => $e->getMessage()]);

}

?>

