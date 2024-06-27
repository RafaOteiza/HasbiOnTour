<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, apellido, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nombre, $apellido, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Correo o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
}
?>
