<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php';

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el correo electrónico ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error en prepare: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado.']);
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error en prepare: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssss", $nombre, $apellido, $email, $password);
    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        echo json_encode(['status' => 'success', 'message' => 'Registro exitoso. Ahora puede iniciar sesión.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en execute: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
