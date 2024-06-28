<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, apellido, password, is_admin FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Error en prepare: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nombre, $apellido, $hashedPassword, $is_admin);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['is_admin'] = $is_admin;

            if ($is_admin) {
                echo json_encode(['status' => 'success', 'redirect' => 'dashboard_admin.php']);
            } else {
                echo json_encode(['status' => 'success', 'redirect' => 'dashboard.php']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Correo no encontrado']);
    }

    $stmt->close();
    $conn->close();
}
?>
