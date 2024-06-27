<?php
$servername = "localhost";
$username = "root";
$password = "ing_software";
$dbname = "HasbiOnTour";
$port = 3308;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
