<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = intval($data['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM RopaSeleccionada WHERE id_seleccion = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
