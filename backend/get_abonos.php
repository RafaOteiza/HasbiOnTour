<?php
include 'config.php';

$sql = "SELECT a.id, u.nombre, u.apellido, a.fecha, a.monto FROM abonos a JOIN usuarios u ON a.usuario_id = u.id";
$result = $conn->query($sql);

$abonos = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $abonos[] = $row;
    }
}

echo json_encode($abonos);
$conn->close();
?>
