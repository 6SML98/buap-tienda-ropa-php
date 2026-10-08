<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT rs.*, p.imagen FROM RopaSeleccionada rs JOIN Productos p ON rs.id_producto = p.id_producto WHERE rs.id_usuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($productos);
?>
