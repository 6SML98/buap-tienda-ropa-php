<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['user_id'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['tipo'] = $usuario['tipo'];

        if ($usuario['tipo'] == 1) {
            header('Location: ../../admin/admin.html');
        } else {
            header('Location: ../../products/playeras.php');
        }
        exit;
    } else {
        header('Location: ../../login.html?error=1');
        exit;
    }
}
?>
