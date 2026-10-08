<?php

require '../db.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = htmlspecialchars($_POST['nombre']);

    $apellido = htmlspecialchars($_POST['apellido']);

    $correo = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $direccion = htmlspecialchars($_POST['direccion']);

    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $tipo = 0; // El registro público crea cuentas de cliente.



    try {

        $stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, apellido, correo, contrasena, direccion, fecha_nacimiento, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$nombre, $apellido, $correo, $contrasena, $direccion, $fecha_nacimiento, $tipo]);



        header("Location: ../../login.html?registro=exito");

        exit;

    } catch (PDOException $e) {

        die("Error al registrar usuario: " . $e->getMessage());

    }

}

?>

