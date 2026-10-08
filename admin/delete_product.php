<?php
require_once __DIR__ . "/../includes/admin_session.php";

require '../includes/db.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_NUMBER_INT);



    try {

        $stmt = $pdo->prepare("DELETE FROM Productos WHERE id_producto = ?");

        $stmt->execute([$id_producto]);

        echo "<script>alert('Producto eliminado exitosamente'); window.location.href='admin.html';</script>";

    } catch (PDOException $e) {

        die("Error al eliminar producto: " . $e->getMessage());

    }

}

?>

