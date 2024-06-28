<?php
include 'config.php';

$sql = "SELECT r.id, u.nombre, u.apellido, r.tipo, r.fecha FROM reportes r JOIN usuarios u ON r.usuario_id = u.id";
$result = $conn->query($sql);

$reportes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reportes[] = $row;
    }
}

echo json_encode($reportes);
$conn->close();
?>
