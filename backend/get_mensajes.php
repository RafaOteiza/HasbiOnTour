<?php
include 'config.php';

$sql = "SELECT m.id, u.nombre, u.apellido, m.mensaje, m.fecha FROM mensajes m JOIN usuarios u ON m.usuario_id = u.id";
$result = $conn->query($sql);

$mensajes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mensajes[] = $row;
    }
}

echo json_encode($mensajes);
$conn->close();
?>
