<?php
include 'config.php';

$sql = "SELECT c.id, u.nombre, u.apellido, c.tipo, c.fecha FROM contratos c JOIN usuarios u ON c.usuario_id = u.id";
$result = $conn->query($sql);

$contratos = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contratos[] = $row;
    }
}

echo json_encode($contratos);
$conn->close();
?>
