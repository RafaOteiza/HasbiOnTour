<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_SESSION['usuario_id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Verificar que las nuevas contraseñas coincidan
    if ($newPassword !== $confirmPassword) {
        echo "Las contraseñas nuevas no coinciden.";
        exit();
    }

    // Obtener la contraseña actual del usuario desde la base de datos
    $query = $conn->prepare("SELECT password FROM usuarios WHERE id = ?");
    $query->bind_param("i", $usuarioId);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    // Verificar que la contraseña actual ingresada coincida con la almacenada en la base de datos
    if (!password_verify($oldPassword, $user['password'])) {
        echo "La contraseña actual es incorrecta.";
        exit();
    }

    // Encriptar la nueva contraseña
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $updateQuery = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    $updateQuery->bind_param("si", $hashedNewPassword, $usuarioId);

    if ($updateQuery->execute()) {
        echo "Contraseña cambiada exitosamente.";
    } else {
        echo "Error al cambiar la contraseña: " . $conn->error;
    }

    $query->close();
    $updateQuery->close();
    $conn->close();
}
?>
