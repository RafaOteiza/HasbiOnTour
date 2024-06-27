<?php
require('../fpdf/fpdf.php');
include 'config.php';

// Obtener el ID del reporte
$report_id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM abonos WHERE id = ?");
$query->bind_param("i", $report_id);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $user_query = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $user_query->bind_param("i", $row['user_id']);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user_row = $user_result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar título
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Reporte de Abonos');
    $pdf->Ln(20);

    // Agregar datos del usuario
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(40,10,'Nombre: ' . $user_row['nombre']);
    $pdf->Ln(10);
    $pdf->Cell(40,10,'Apellido: ' . $user_row['apellido']);
    $pdf->Ln(10);
    $pdf->Cell(40,10,'Correo: ' . $user_row['email']);
    $pdf->Ln(20);

    // Agregar datos del reporte
    $pdf->Cell(40,10,'Fecha: ' . $row['fecha']);
    $pdf->Ln(10);
    $pdf->Cell(40,10,'Monto: ' . $row['monto']);
    $pdf->Ln(10);

    // Output PDF
    $pdf->Output('D', 'reporte_abono.pdf'); // D para forzar la descarga
} else {
    echo 'Reporte no encontrado';
}

$query->close();
$conn->close();
?>
