<?php
include 'config.php';

$name = $_POST['name'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Comprobar si el correo electrónico ya existe
$query = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "El correo electrónico ya está registrado. <a href=\"javascript:void(0);\" onclick=\"showLoginModal()\">Iniciar sesión</a>"
    ]);
} else {
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $lastName, $email, $password);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Registro exitoso. <a href=\"javascript:void(0);\" onclick=\"showLoginModal()\">Iniciar sesión</a>"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Ocurrió un error al registrar el usuario."
        ]);
    }

    $stmt->close();
}

$query->close();
$conn->close();
?>
